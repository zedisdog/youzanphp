<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


use Dezsidog\Youzanphp\Contract\Params;

class SalesmanByTradeId implements Params
{
    /**
     * @var string
     */
    public $order_no;

    public function __construct(string $tradeId)
    {
        $this->order_no = $tradeId;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}