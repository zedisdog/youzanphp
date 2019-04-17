<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Oauth2;


class Oauth
{
    /**
     * 获取token
     */
    const TOKEN = 1;
    /**
     * 刷新token
     */
    const REFRESH = 2;

    const URL = 'https://open.youzanyun.com/auth/token';

    private $clientId;
    private $clientSecret;
    private $type;
    /**
     * @var string code或者refresh_token type不一样 $code的作用不一样
     */
    private $code;

    public function __construct(string $clientId, string $clientSecret, int $type, string $code)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->type = $type;
        $this->code = $code;
    }

    public function getToken(): Token
    {

    }
}