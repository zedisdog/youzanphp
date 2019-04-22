<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class CouponDetail extends BaseModel
{
    /**
     * @var int 活动ID
     */
    public $id;
    /**
     * @var int 店铺ID
     */
    public $kdtId;
    /**
     * @var int 优惠券类型。7：优惠券；9：优惠码-一卡一码；10：优惠码-通用码
     */
    public $groupType;
    /**
     * @var string 优惠券名称
     */
    public $title;
    /**
     * @var int 优惠属性。1：优惠；2：折扣
     */
    public $preferentialType;
    /**
     * @var int 面额（单位分）
     */
    public $denominations;
    /**
     * @var int 面额随机值上限，不随机为0
     */
    public $valueRandomTo;
    /**
     * @var int 满额条件
     */
    public $condition;
    /**
     * @var int 折扣（88，8.8折）
     */
    public $discount;
    /**
     * @var int 是否限制。n：1个人限领n次(n<=10)；0：不限制
     */
    public $isLimit;
    /**
     * @var bool 是否仅原价购买商品时可用。true：是；false：否
     */
    public $isForbidPreference;
    /**
     * @var int 会员等级
     */
    public $userLevel;
    /**
     * @var int 优惠使用时间类型。1：表示固定活动时间；2：表示延迟类型，几天后几天内有效
     */
    public $dateType;
    /**
     * @var int 从领券日期开始算起，固定延时N天开始
     */
    public $fixedTerm;
    /**
     * @var int 从领券日期开始算起，延迟开始的天数(目前支持0和1，表示当日和次日)
     */
    public $fixedBeginTerm;
    /**
     * @var Carbon 有效开始时间
     */
    public $validStartTime;
    /**
     * @var Carbon 有效结束时间
     */
    public $validEndTime;
    /**
     * @var int 总发放量
     */
    public $totalQty;
    /**
     * @var int 库存数量
     */
    public $stockQty;
    /**
     * @var string 使用范围类型。part：部分商品可用；all：全部商品可用
     */
    public $rangeType;
    /**
     * @var string 使用范围值
     */
    public $rangeValue;
    /**
     * @var bool 到期是否提醒。true：是；false：否
     */
    public $expireNotice;
    /**
     * @var string 使用说明
     */
    public $description;
    /**
     * @var Carbon 创建时间
     */
    public $createdAt;
    /**
     * @var Carbon 更新时间
     */
    public $updatedAt;
    /**
     * @var bool 是否同步微信卡包。true：是；false：否
     */
    public $isSyncWeixin;
    /**
     * @var bool 是否失效。false：未失效；true：已失效
     */
    public $isInvalid;
    /**
     * @var int 粉丝领取总人数（去重）
     */
    public $totalFansTaked;
    /**
     * @var int 总使用数
     */
    public $totalUsed;
    /**
     * @var int 总领取数
     */
    public $totalTake;
    /**
     * @var bool 是否允许分享优惠券。false：否；true：是
     */
    public $isShare;
    /**
     * @var string 券或码链接
     */
    public $url;
    /**
     * @var array
     */
    protected $dates = [
        'valid_start_time',
        'valid_end_time',
        'created_at',
        'updated_at'
    ];
    /**
     * @var array
     */
    protected $booleans = [
        'is_forbid_preference',
        'is_sync_weixin',
        'is_invalid',
        'is_share'
    ];
}