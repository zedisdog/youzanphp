<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp;


use Dezsidog\Youzanphp\Contract\Params;
use Dezsidog\Youzanphp\Exceptions\BadRequestException;
use Dezsidog\Youzanphp\Exceptions\ResponseEmptyException;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class BaseClient
{
    protected $client;
    protected $logger;

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

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(Request $request): array
    {
        $this->logger->info(sprintf("+request oauth url: %s body: %s", $request->getUri(), $request->getBody()));

        $response = $this->client->send($request);

        $body = $response->getBody();
        $this->logger->info("-response " . $body);
        $data = \GuzzleHttp\json_decode($body, true);
        if (empty($data)) {
            throw new ResponseEmptyException("response is empty");
        }
        if ($data['code'] != 200 || $data['success'] != true) {
            throw new BadRequestException($data['success'], $data['code'], $data['message']);
        }

        return $data['data'];
    }

    abstract protected function makeRequest(string $url, ?Params $params = null, string $method = 'POST'): Request;
}