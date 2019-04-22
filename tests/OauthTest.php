<?php
/**
 * Created by zed.
 */

class OauthTest extends \PHPUnit\Framework\TestCase
{
    protected $clientId = "";
    protected $clientSecret = "";
    protected $code = "";
    protected $redirectUri = "";

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testRequestAndRefreshToken() {
        $auth = new \Dezsidog\Youzanphp\Oauth2\Oauth($this->clientId, $this->clientSecret);
        $token = $auth->requestToken($this->code, $this->redirectUri);

        $this->assertNotEmpty($token['refresh_token']);

        $token = $auth->refreshToken($token['refresh_token']);

        $this->assertNotEmpty($token['access_token']);
    }
}