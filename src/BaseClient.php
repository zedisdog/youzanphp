<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp;


use Dezsidog\Youzanphp\Exceptions\BadRequestException;
use Dezsidog\Youzanphp\Exceptions\BusinessErrorException;
use Dezsidog\Youzanphp\Exceptions\ForbidException;
use Dezsidog\Youzanphp\Exceptions\InvalidApiException;
use Dezsidog\Youzanphp\Exceptions\InvalidContentException;
use Dezsidog\Youzanphp\Exceptions\InvalidModeException;
use Dezsidog\Youzanphp\Exceptions\InvalidRequestException;
use Dezsidog\Youzanphp\Exceptions\InvalidUrlException;
use Dezsidog\Youzanphp\Exceptions\MoreRequestException;
use Dezsidog\Youzanphp\Exceptions\ResponseEmptyException;
use Dezsidog\Youzanphp\Exceptions\ServerErrorException;
use Dezsidog\Youzanphp\Exceptions\TokenException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

abstract class BaseClient
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var Logger
     */
    protected $logger;
    /**
     * @var bool
     */
    protected $dontReportAll = false;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        if ($logger) {
            $this->logger = $logger;
        } else {
            $this->logger = new Logger('oauth');
            $this->logger->pushHandler(new StreamHandler('php://stderr'));
        }
    }

    public function dontReportAll()
    {
        $this->dontReportAll = true;
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(Request $request)
    {
        $this->logger->info(sprintf("+request oauth url: %s body: %s", $request->getUri(), $request->getBody()));

        $response = $this->client->send($request);

        $body = $response->getBody();
        $this->logger->info("-response " . $body);
        $data = \GuzzleHttp\json_decode($body, true);
        $error = true;
        if (empty($data)) {
            if (!$this->dontReportAll) {
                throw new ResponseEmptyException("response is empty");
            }
            $this->logger->warning('response is empty');
        } elseif (isset($data['gw_err_resp'])) {
            if (!$this->dontReportAll) {
                $this->throwGatewayExceptions($data);
            }
            $this->logger->warning(sprintf('response has global errors: [code: %d, message: %s]', $error['err_code'], $error['err_msg']));
        } elseif ((isset($data['code']) && $data['code'] != 200) || (isset($data['success']) && $data['success'] != true)) {
            if (!$this->dontReportAll) {
                throw new BadRequestException($data['success'], $data['code'], $data['message']);
            }
            $this->logger->warning(sprintf("bad request: [code: %d, success: %s, message: %s]", $data['code'], $data['success'] ? "true" : "false", $data['message']));
        } elseif (isset($data['error_response'])) {
            if (!$this->dontReportAll) {
                throw new BadRequestException(false, $data['error_response']['code'], $data['error_response']['msg']);
            }
            $this->logger->warning(sprintf("bad request: [code: %d, success: %s, message: %s]", $data['error_response']['code'], false ? "true" : "false", $data['error_response']['msg']));
        } else {
            $error = false;
        }

        if ($error) {
            return null;
        } elseif(!isset($data['data'])) {
            return $data['response'];
        } else {
            return $data['data'];
        }
    }

    abstract protected function makeRequest(string $url, ?array $params = null, string $method = 'POST'): Request;

    /**
     * @param $error
     * @throws \RuntimeException
     */
    protected function throwGatewayExceptions($error)
    {
        switch ($error['err_code']) {
            case 4201:
            case 4202:
            case 4203:
                throw new TokenException($error['err_msg'], $error['err_code']);
                break;
            case 4001:
                throw new InvalidUrlException($error['err_msg'], $error['err_code']);
                break;
            case 4004:
                throw new InvalidContentException($error['err_msg'], $error['err_code']);
                break;
            case 4005:
                throw new InvalidApiException($error['err_msg'], $error['err_code']);
                break;
            case 4006:
                throw new InvalidModeException($error['err_msg'], $error['err_code']);
                break;
            case 4007:
                throw new InvalidRequestException($error['err_msg'], $error['err_code']);
                break;
            case 4101:
                throw new MoreRequestException($error['err_msg'], $error['err_code']);
                break;
            case 4204:
                throw new ForbidException($error['err_msg'], $error['err_code']);
                break;
            case 5001:
                throw new ServerErrorException($error['err_msg'], $error['err_code']);
                break;
            case 5002:
                throw new BusinessErrorException($error['err_msg'], $error['err_code']);
                break;
            default:
                throw new \RuntimeException($error['err_msg'], $error['err_code']);
        }
    }
}