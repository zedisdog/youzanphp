<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Oauth2;


use Dezsidog\Youzanphp\Contract\Request;
use Dezsidog\Youzanphp\Exceptions\BadRequestException;
use Dezsidog\Youzanphp\Exceptions\ResponseEmptyException;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Oauth
{
    const URL = 'https://open.youzanyun.com/auth/token';

    protected $clientId;
    protected $clientSecret;
    protected $client;
    protected $logger;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->client = new Client([
            'base_uri' => self::URL,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        $this->logger = new Logger('oauth');
        $this->logger->pushHandler(new StreamHandler('php://stderr'));
    }

    /**
     * 请求token
     * @param string $redirectUri
     * @return Token
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestToken(string $code, string $redirectUri): Token
    {
        $request = new TokenRequest($this->clientId, $this->clientSecret, $code, $redirectUri);
        return new Token($this->request($request));
    }

    /**
     * @param string $refreshToken
     * @return Token
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refreshToken(string $refreshToken): Token
    {
        $request = new RefreshTokenRequest($this->clientId, $this->clientSecret, $refreshToken);
        return new Token($this->request($request));
    }

    /**
     * @param Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(Request $request): array
    {
        $this->logger->info("+request oauth" . $request);
        $response = $this->client->request('POST', '', [
            'json' => $request,
        ]);

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
}