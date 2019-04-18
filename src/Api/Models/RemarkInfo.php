<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class RemarkInfo
{
    /**
     * @var string 订单买家留言
     */
    public $buyerMessage;
    /**
     * @var int 订单标星等级 0-5
     */
    public $star;
    /**
     * @var string 订单商家备注
     */
    public $tradeMemo;

    public $raw;

    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    protected function parse()
    {
        $this->buyerMessage = $this->raw['buyer_message'];
        $this->star = $this->raw['star'];
        $this->tradeMemo = $this->raw['trade_memo'];
    }
}