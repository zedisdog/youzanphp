<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;
use IlluminateAgnostic\Arr\Support\Arr;

/**
 * Class Trade
 * @package Dezsidog\Youzanphp\Client\Models
 * @property-read int $tid 订单号
 * @property-read Carbon $settle_time 结算时间
 * @property-read Carbon $created 订单创建时间
 * @property-read Carbon $update_time 订单更新时间
 * @property-read Carbon $expired_time 订单过期时间（未付款将自动关单）
 * @property-read Carbon $pay_time 订单支付时间
 * @property-read Carbon $consign_time 订单发货时间（当所有商品发货后才会更新）
 * @property-read Carbon $confirm_time 订单确认时间（多人拼团成团）
 * @property-read Carbon $success_time 订单成功时间
 * @property-read Carbon $pay_start_time 支付开始时间
 * @property-read Carbon $pay_end_time 支付结束时间
 * @property-read Carbon $delivery_start_time 同城送预计送达时间-开始时间 非同城送以及没有开启定时达的订单不返回
 * @property-read Carbon $delivery_end_time 同城送预计送达时间-结束时间 非同城送以及没有开启定时达的订单不返回
 * @property-read int $total_fee 订单总价
 * @property-read int $post_fee 邮费
 * @property-read int $payment 最终支付价格 payment=orders.payment的总和
 * @property-read int $real_price 阶段支付金额
 * @property-read int $refund_fee 退款金额
 */
class Trade
{
    /**
     * @var int
     */
    public $tid;
    /**
     * @var Order[]
     */
    public $orders;
    /**
     * @var array
     */
    public $raw;
    /**
     * @var FullOrderInfo
     */
    public $fullOrderInfo;
    /**
     * @var RefundOrder[]
     */
    public $refundOrder;
    /**
     * @var DeliveryOrder[]
     */
    public $deliveryOrder;
    /**
     * @var OrderPromotion
     */
    public $orderPromotion;

    /**
     * Trade constructor.
     * @param array $raw
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function parse() {
        $this->fullOrderInfo = new FullOrderInfo($this->raw['full_order_info']);
        $this->refundOrder = [];
        foreach ($this->raw['refund_order'] as $item) {
            array_push($this->refundOrder, new RefundOrder($item));
        }
        if (isset($this->raw['delivery_order'])) {
            $this->deliveryOrder = [];
            foreach ($this->raw['delivery_order'] as $item) {
                array_push($this->deliveryOrder, new DeliveryOrder($item));
            }
        }
        $this->orderPromotion = new OrderPromotion($this->raw['order_promotion']);
    }

    protected function parseTid()
    {
        $this->tid = Arr::get($this->raw, 'full_order_info.order_info.tid');
    }
}