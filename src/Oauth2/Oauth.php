<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Oauth2;


use Dezsidog\Youzanphp\BaseClient;
use Dezsidog\Youzanphp\Contract\Params;
use GuzzleHttp\Psr7\Request;
use function GuzzleHttp\Psr7\stream_for;

class Oauth extends BaseClient
{
    const URL = 'https://open.youzanyun.com/auth/token';

    protected $clientId;
    protected $clientSecret;

    public function __construct(string $clientId, string $clientSecret)
    {
        parent::__construct();
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * 请求token
     * @param string $redirectUri
     * @return Token
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestToken(string $code, string $redirectUri): Token
    {
        $params = new TokenParams($this->clientId, $this->clientSecret, $code, $redirectUri);
        $request = $this->makeRequest(self::URL, $params);
        $response = $this->request($request);
        return new Token($response);
    }

    /**
     * @param string $refreshToken
     * @return Token
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refreshToken(string $refreshToken): Token
    {
        $params = new RefreshTokenParams($this->clientId, $this->clientSecret, $refreshToken);
        $request = $this->makeRequest(self::URL, $params);
        $response = $this->request($request);
        return new Token($response);
    }

    protected function makeRequest(string $url, ?Params $params = null, string $method = 'POST'): Request {
        return new Request($method, $url, [], stream_for($params));
    }
}