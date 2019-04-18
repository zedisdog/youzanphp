<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class OrderPromotion
{
    /**
     * @var int 商品优惠总金额
     */
    public $itemDiscountFee;
    /**
     * @var int 订单优惠总金额
     */
    public $orderDiscountFee;
    /**
     * @var int 订单改价金额
     */
    public $adjustFee;
    /**
     * @var OrderPromotionItem[] 订单商品级优惠结构结构体
     */
    public $items;
    /**
     * @var OrderPromotionOrder[] 优惠明细结构体
     */
    public $orders;
    /**
     * @var array
     */
    public $raw;

    /**
     * OrderPromotion constructor.
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
    protected function parse()
    {
        if (isset($this->raw['item_discount_fee'])) {
            $this->itemDiscountFee = intval($this->raw['item_discount_fee'] * 100);
        }
        if (isset($this->raw['order_discount_fee'])) {
            $this->orderDiscountFee = intval($this->raw['order_discount_fee'] * 100);
        }
        $this->adjustFee = intval($this->raw['adjust_fee'] * 100);
        if(isset($this->raw['item'])){
            $this->items = [];
            foreach ((array)$this->raw['item'] as $item) {
                array_push($this->items, new OrderPromotionItem($item));
            }
        }
        if (isset($this->raw['order'])){
            $this->orders = [];
            foreach ((array)$this->raw['order'] as $item) {
                array_push($this->orders, new OrderPromotionOrder($item));
            }
        }
    }
}