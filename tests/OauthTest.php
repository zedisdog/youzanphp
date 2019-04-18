<?php
/**
 * Created by zed.
 */

class OauthTest extends \PHPUnit\Framework\TestCase
{
    protected $clientId = "be9a06911147e350b0";
    protected $clientSecret = "dfee7097a9b77c394c2439c838e95ef8";
    protected $code = "874b4877cc7bca92cf15291b1a9f11d4";
    protected $redirectUri = "http://devbbdapi.ffuture.cn/api/yz/newcallback";

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testRequestAndRefreshToken() {
        $auth = new \Dezsidog\Youzanphp\Oauth2\Oauth($this->clientId, $this->clientSecret);
        $token = $auth->requestToken($this->code, $this->redirectUri);

        $this->assertNotEmpty($token->refreshToken);

        $token = $auth->refreshToken($token->refreshToken);

        $this->assertNotEmpty($token->accessToken);
    }
}