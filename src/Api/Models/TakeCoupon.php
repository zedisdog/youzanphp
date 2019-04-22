<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


class TakeCoupon extends BaseModel
{
    /**
     * @var string 优惠活动类型。1：PROMOCODE：优惠码；2.PROMOCARD：优惠券
     */
    public $couponType;
    /**
     * @var PromoCode 用户领取优惠码详情（优惠码or优惠券详情只返回其一）
     */
    public $promocode;
    /**
     * @var PromoCard 用户领取优惠券详情（优惠码or优惠券详情只返回其一）
     */
    public $promocard;

    protected $objects = [
        'promocode' => PromoCode::class,
        'promocard' => PromoCard::class,
    ];
}