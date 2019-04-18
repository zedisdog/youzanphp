<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Oauth2;


class Token
{
    public $accessToken;
    public $refreshToken;
    public $expires;
    public $scope;

    public function __construct(array $data)
    {
        $this->accessToken = $data['access_token'];
        $this->expires = $data['expires'];
        $this->refreshToken = $data['refresh_token'];
        $this->scope = $data['scope'];
    }
}