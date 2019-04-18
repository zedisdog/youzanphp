<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


class Client
{
    protected $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}