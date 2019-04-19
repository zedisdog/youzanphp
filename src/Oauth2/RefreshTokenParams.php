<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Oauth2;


use Dezsidog\Youzanphp\Contract\Params;

class RefreshTokenParams implements Params
{
    public $authorize_type = "refresh_token";
    public $refresh_token;
    public $client_id;
    public $client_secret;

    public function __construct(string $clientId, string $clientSecret, string $refreshToken)
    {
        $this->refresh_token = $refreshToken;
        $this->client_id = $clientId;
        $this->client_secret = $clientSecret;
    }

    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}