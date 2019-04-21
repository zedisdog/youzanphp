<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Params;

class Trade extends BaseParams
{
    public $tid;

    public function __construct(string $tid)
    {
        $this->tid = $tid;
    }
}