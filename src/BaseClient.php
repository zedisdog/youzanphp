<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp;


use Dezsidog\Youzanphp\Contract\Params;
use Dezsidog\Youzanphp\Exceptions\BadRequestException;
use Dezsidog\Youzanphp\Exceptions\ResponseEmptyException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        $this->logger = new Logger('oauth');
        $this->logger->pushHandler(new StreamHandler('php://stderr'));
    }

    public function dontReportAll()
    {
        $this->dontReportAll = true;
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(Request $request): ?array
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
        } elseif ($data['code'] != 200 || $data['success'] != true) {
            if (!$this->dontReportAll) {
                throw new BadRequestException($data['success'], $data['code'], $data['message']);
            }
            $this->logger->warning(sprintf("bad request: [code: %d, success: %s, message: %s]", $data['code'], $data['success'] ? "true" : "false", $data['message']));
        } else {
            $error = false;
        }

        if ($error) {
            return null;
        } else {
            return $data['data'];
        }
    }

    abstract protected function makeRequest(string $url, ?Params $params = null, string $method = 'POST'): Request;
}