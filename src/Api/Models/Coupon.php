<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class Coupon extends BaseModel
{
    /**
     * @var int 优惠活动id
     */
    public $groupId;
    /**
     * @var string 优惠的类型。PROMOCARD：优惠券；PROMOCODE：优惠码
     */
    public $couponType;
    /**
     * @var string 使用范围类型。part：部分商品可用；all：全部商品可用
     */
    public $rangeType;
    /**
     * @var string 优惠券/码名称
     */
    public $title;
    /**
     * @var int 优惠面额。如果 is_random 为 1，则该字段表示随机金额的下限。单位：分，精确到分
     */
    public $value;
    /**
     * @var bool 是否是随机优惠。false：不随机；true：随机
     */
    public $isRandom;
    /**
     * @var int 如果 is_random 为 1，则该字段表示随机金额的上限。单位：分，精确到分
     */
    public $valueRandomTo;
    /**
     * @var int  是否限制领用者的等级。0表示不限制，大于 0 表示领用者必须是这个等级ID
     */
    public $needUserLevel;
    /**
     * @var string 限制领用者等级的名称
     */
    public $userLevelName;
    /**
     * @var int 每人限领个数，为 0 则表示不限制
     */
    public $quota;
    /**
     * @var bool 是否设置满多少元可用，false 表示不限制，true 表示限制
     */
    public $isAtLeast;
    /**
     * @var int 如果 is_at_least 为 1，该字段表示订单必须满这个价格，优惠才可用。单位：分，精确到分
     */
    public $atLeast;
    /**
     * @var int 库存
     */
    public $total;
    /**
     * @var int 剩余可用库存
     */
    public $stock;
    /**
     * @var Carbon 优惠生效时间
     */
    public $startAt;
    /**
     * @var Carbon 优惠结束时间
     */
    public $endAt;
    /**
     * @var bool 到期前是否提醒。true：是；false：否
     */
    public $expireNotice;
    /**
     * @var string 使用说明
     */
    public $description;
    /**
     * @var bool 是否仅原价购买商品时可用，false 表示否，true 表示是
     */
    public $isForbidPreference;
    /**
     * @var bool 是否同步微信卡券，false 表示否，true 表示是
     */
    public $isSyncWeixin;
    /**
     * @var string 微信卡券ID
     */
    public $weixinCardId;
    /**
     * @var int 优惠状态，0 表示有效，1 表示失效，2 表示微信卡券审核中
     */
    public $status;
    /**
     * @var bool 是否可分享领取链接，false 表示否，true 表示是
     */
    public $isShare;
    /**
     * @var string 优惠领取链接
     */
    public $fetchUrl;
    /**
     * @var int 领取优惠的人数
     */
    public $statFetchUserNum;
    /**
     * @var int 领取优惠的次数
     */
    public $statFetchNum;
    /**
     * @var int 使用优惠的次数
     */
    public $statUseNum;
    /**
     * @var Carbon 优惠创建时间
     */
    public $created;
    /**
     * @var Carbon 优惠券更新时间
     */
    public $updated;
    /**
     * @var array
     */
    protected $dates = [
        'start_at',
        'end_at',
        'created',
        'updated'
    ];
    /**
     * @var array
     */
    protected $booleans = [
        'is_random',
        'is_at_least',
        'expire_notice',
        'is_forbid_preference',
        'is_sync_weixin',
        'is_share'
    ];
    /**
     * @var array
     */
    protected $prices = [
        'value',
        'value_random_to',
        'at_least'
    ];
}