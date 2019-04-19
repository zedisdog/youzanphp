<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Oauth2;


use Dezsidog\Youzanphp\Contract\Params;

class TokenParams implements Params
{
    public $client_id;
    public $client_secret;
    public $code;
    public $redirect_uri;
    public $authorize_type = 'authorization_code';

    /**
     * TokenRequest constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $code
     * @param string $redirectUri
     */
    public function __construct(string $clientId, string $clientSecret, string $code, string $redirectUri)
    {
        $this->client_id = $clientId;
        $this->client_secret = $clientSecret;
        $this->code = $code;
        $this->redirect_uri = $redirectUri;
    }

    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}