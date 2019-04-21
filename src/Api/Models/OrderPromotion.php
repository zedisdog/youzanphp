<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class OrderPromotion extends BaseModel
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

    protected $prices = [
        'item_discount_fee',
        'order_discount_fee',
        'adjust_fee',
    ];

    protected $lists = [
        'item' => [
            'propName' => 'items',
            'class' => OrderPromotionItem::class
        ],
        'order' => [
            'propName' => 'orders',
            'class' => OrderPromotionOrder::class
        ],
    ];
}