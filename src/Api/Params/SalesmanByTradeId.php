<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;

class SalesmanByTradeId extends BaseParams
{
    /**
     * @var string
     */
    public $order_no;

    public function __construct(string $tradeId)
    {
        $this->order_no = $tradeId;
    }
}