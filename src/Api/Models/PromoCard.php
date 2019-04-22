<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class PromoCard extends BaseModel
{
    /**
     * @var int 优惠券 id
     */
    public $promocardId;
    /**
     * @var string 优惠券标题
     */
    public $title;
    /**
     * @var int 面额（单位：分）
     */
    public $value;
    /**
     * @var int 优惠券满额条件
     */
    public $condition;
    /**
     * @var Carbon 优惠券生效时间
     */
    public $startAt;
    /**
     * @var Carbon 优惠券过期时间
     */
    public $endAt;
    /**
     * @var bool 优惠券是否已使用。false：未使用；true ：已使用
     */
    public $isUsed;
    /**
     * @var bool 优惠券是否已失效。false：未失效；true：已失效
     */
    public $isInvalid;
    /**
     * @var bool 优惠券是否已过期。false：未过期；true：已过期
     */
    public $isExpired;
    /**
     * @var string 	优惠券背景颜色
     */
    public $backgroundColor;
    /**
     * @var string 优惠券详情链接
     */
    public $detailUrl;
    /**
     * @var string 核销码
     */
    public $verifyCode;
    /**
     * @var int 优惠属性。1：优惠；2：折扣
     */
    public $preferentialType;
    /**
     * @var int 折扣（88，8.8折）
     */
    public $discount;

    protected $booleans = [
        'is_used',
        'is_invalid',
        'is_expired'
    ];
    /**
     * @var array
     */
    protected $dates = [
        'start_at',
        'end_at',
    ];
}