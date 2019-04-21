<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class Promotion extends BaseModel
{
    /**
     * @var string 优惠类型 tuan:团购返现 auction:降价拍 groupOn:多人拼团 pointsExchange:积分抵扣 seckill:秒杀 packageBuy:优惠套餐 presentExchange:赠品领取 goodsScan:商品扫码 customerDiscount:会员折扣 timelimitedDiscount:限时折扣 paidPromotion:支付有礼 periodBuy:周期购 scanReduce:收款码优惠 meetReduce:满减送 cashBack:订单返现 supplierMeetReduce:供货商满包邮 bale:打包一口价 coupon:优惠卡券 entireDiscount:整单优惠 groupOnHeaderDiscount:团长优惠 customerPostageFree:会员包邮 periodBuyPostageFree:周期购包邮 ignoreOddChange:抹零 pfGuideMarketing:引导促销 helpCut:助力砍价 sellerDiscount:分销商等级折扣
     */
    public $promotionType;
    /**
     * @var string 优惠别名
     */
    public $promotionTitle;
    /**
     * @var string 优惠类型描述
     */
    public $promotionTypeName;
    /**
     * @var int 优惠类型id
     */
    public $promotionTypeId;
    /**
     * @var int 优惠金额 *
     */
    public $discountFee;
    /**
     * @var string 优惠描述
     */
    public $promotionCondition;
    /**
     * @var string 优惠活动别名
     */
    public $promotionContent;
    /**
     * @var int 优惠id
     */
    public $promotionId;
    /**
     * @var string 优惠子类型 card 优惠券 code 优惠码
     */
    public $subPromotionType;
    /**
     * @var string 优惠券/码编号
     */
    public $couponId;

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if ($key == 'discount_fee') {
                $value = intval($value * 100);
            }

            $this->$propName = $value;
        }
    }
}