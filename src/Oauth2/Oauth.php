<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Oauth2;


use Dezsidog\Youzanphp\BaseClient;
use GuzzleHttp\Psr7\Request;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Log\LoggerInterface;

class Oauth extends BaseClient
{
    const URL = 'https://open.youzanyun.com/auth/token';

    protected $clientId;
    protected $clientSecret;

    public function __construct(string $clientId, string $clientSecret, ?LoggerInterface $logger = null)
    {
        parent::__construct($logger);
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param int $shopId
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestTokenSilent(int $shopId) {
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_id' => $shopId,
            'authorize_type' => 'silent'
        ];
        $request = $this->makeRequest(self::URL, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 请求token
     * @param string $code
     * @param string $redirectUri
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestToken(string $code, string $redirectUri): ?array
    {
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $redirectUri,
            'authorize_type' => 'authorization_code',
            'code' => $code
        ];
        $request = $this->makeRequest(self::URL, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * @param string $refreshToken
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refreshToken(string $refreshToken): ?array
    {
        $params = [
            'authorize_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ];
        $request = $this->makeRequest(self::URL, $params);
        $response = $this->request($request);
        return $response;
    }

    protected function makeRequest(string $url, ?array $params = null, string $method = 'POST'): Request {
        if (is_array($params)) {
            $params = \GuzzleHttp\json_encode($params);
        }
        return new Request($method, $url, [], stream_for($params));
    }
}