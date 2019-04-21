<?php


namespace Dezsidog\Youzanphp\Api\Params;


use Dezsidog\Youzanphp\Contract\Params;

class BaseParams implements Params
{

    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}