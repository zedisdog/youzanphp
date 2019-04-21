<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class OrderPromotionItem extends BaseModel
{
    /**
     * @var bool 是否赠品
     */
    public $isPresent;
    /**
     * @var string 交易明细id
     */
    public $oid;
    /**
     * @var int 商品id
     */
    public $itemId;
    /**
     * @var int 规格id
     */
    public $skuId;
    /**
     * @var Promotion[] 优惠明细结构体
     */
    public $promotions;

    protected $lists = [
        'promotions' => Promotion::class
    ];
}