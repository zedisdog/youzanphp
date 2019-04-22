<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class PromoCode extends BaseModel
{
    /**
     * @var int 优惠码id
     */
    public $promocodeId;
    /**
     * @var string 优惠码标题
     */
    public $title;
    /**
     * @var string 优惠码编号
     */
    public $code;
    /**
     * @var int 优惠码面额（单位：分）
     */
    public $value;
    /**
     * @var int 优惠码满额条件
     */
    public $condition;
    /**
     * @var Carbon 优惠码生效时间
     */
    public $startAt;
    /**
     * @var Carbon 优惠码过期时间
     */
    public $endAt;
    /**
     * @var bool 优惠码是否已使用。false：未使用；true ：已使用
     */
    public $isUsed;
    /**
     * @var bool 优惠码是否已失效。false：未失效；true：已失效
     */
    public $isInvalid;
    /**
     * @var bool 优惠码是否已过期。false：未过期；true：已过期
     */
    public $isExpired;
    /**
     * @var string 优惠码背景颜色
     */
    public $backgroundColor;
    /**
     * @var string 优惠码详情链接
     */
    public $detailUrl;
    /**
     * @var string 核销码
     */
    public $verifyCode;
    /**
     * @var array
     */
    protected $dates = [
        'start_at',
        'end_at'
    ];
}