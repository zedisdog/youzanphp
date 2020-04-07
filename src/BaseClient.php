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
            ],
            'verify' => false
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
    public function request(Request $request)
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
            $this->logger->warning(sprintf('response is empty, url: %s, body: %s', $request->getUri(), $request->getBody()));
        } elseif (isset($data['gw_err_resp'])) {
            $this->throwGatewayExceptions($data);
            $this->logger->warning(sprintf('response has global errors: [url: %s, body: %s, code: %d, message: %s]', $request->getUri(), $request->getBody(), $error['err_code'], $error['err_msg']));
        } elseif ((isset($data['code']) && $data['code'] != 200) || (isset($data['success']) && $data['success'] != true)) {
            if (!$this->dontReportAll) {
                throw new BadRequestException($data['success'] ?? false, intval($data['code']), strval($data['message']));
            }
            $this->logger->warning(sprintf("bad request: [url: %s, body: %s, code: %d, success: %s, message: %s]", $request->getUri(), $request->getBody(), $data['code'], (isset($data['success']) && $data['success']) ? "true" : "false", $data['message']));
        } elseif (isset($data['error_response'])) {
            if (!$this->dontReportAll) {
                throw new BadRequestException(false, intval($data['error_response']['code']), strval($data['error_response']['msg']));
            }
            $this->logger->warning(sprintf("bad request: [url: %s, body: %s, code: %d, success: %s, message: %s]", $request->getUri(), $request->getBody(), $data['error_response']['code'], false ? "true" : "false", $data['error_response']['msg']));
        } else {
            $error = false;
        }

        if ($error) {
            return null;
        } elseif(!isset($data['data']) || isset($data['page_num'])) { // 当没有data字段，或者有分页等其他控制字段在外层时，原样返回
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
        switch ($error['gw_err_resp']['err_code']) {
            case 4201:
            case 4202:
            case 4203:
                $e = new TokenException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4001:
                $e = new InvalidUrlException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4004:
                $e = new InvalidContentException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4005:
                $e = new InvalidApiException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4006:
                $e = new InvalidModeException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4007:
                $e = new InvalidRequestException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4101:
                $e = new MoreRequestException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 4204:
                $e = new ForbidException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 5001:
                $e = new ServerErrorException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            case 5002:
                $e = new BusinessErrorException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
                break;
            default:
                $e = new \RuntimeException(strval($error['gw_err_resp']['err_msg']), intval($error['gw_err_resp']['err_code']));
        }

        if ($e instanceof TokenException || !$this->dontReportAll) {
            throw $e;
        }
    }
}