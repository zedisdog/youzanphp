<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Params;


use Dezsidog\Youzanphp\Contract\Params;

class Trade implements Params
{
    public $tid;

    public function __construct(string $tid)
    {
        $this->tid = $tid;
    }

    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}