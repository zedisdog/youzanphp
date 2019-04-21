<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;
use Jawira\CaseConverter\Convert;

class OrderInfo extends BaseModel
{
    /**
     * @var string 主订单状态 WAIT_BUYER_PAY （等待买家付款，定金预售描述：定金待付、等待尾款支付开始、尾款待付）； TRADE_PAID（订单已支付 ）； WAIT_CONFIRM（待确认，包含待成团、待接单等等。即：买家已付款，等待成团或等待接单）； WAIT_SELLER_SEND_GOODS（等待卖家发货，即：买家已付款）； WAIT_BUYER_CONFIRM_GOODS (等待买家确认收货，即：卖家已发货) ； TRADE_SUCCESS（买家已签收以及订单成功）； TRADE_CLOSED（交易关闭）； PS：TRADE_PAID状态仅代表当前订单已支付成功，表示瞬时状态，稍后会自动修改成后面的状态。如果不关心此状态请再次请求详情接口获取下一个状态。
     */
    public $status;
    /*
     * @var int 主订单类型 0:普通订单; 1:送礼订单; 2:代付; 3:分销采购单; 4:赠品; 5:心愿单; 6:二维码订单; 7:合并付货款; 8:1分钱实名认证; 9:品鉴; 10:拼团; 15:返利; 35:酒店; 40:外卖; 41:堂食点餐; 46:外卖买单; 51:全员开店; 61:线下收银台订单; 71:美业预约单; 72:美业服务单; 75:知识付费; 81:礼品卡; 100:批发
     */
    public $type;
    /**
     * @var string 订单号
     */
    public $tid;
    /**
     * @var string 主订单状态 描述
     */
    public $statusStr;
    /**
     * @var int 支付类型 0:默认值,未支付; 1:微信自有支付; 2:支付宝wap; 3:支付宝wap; 5:财付通; 7:代付; 8:联动优势; 9:货到付款; 10:大账号代销; 11:受理模式; 12:百付宝; 13:sdk支付; 14:合并付货款; 15:赠品; 16:优惠兑换; 17:自动付货款; 18:爱学贷; 19:微信wap; 20:微信红包支付; 21:返利; 22:ump红包; 24:易宝支付; 25:储值卡; 27:qq支付; 28:有赞E卡支付; 29:微信条码; 30:支付宝条码; 33:礼品卡支付; 35:会员余额; 72:微信扫码二维码支付; 100:代收账户; 300:储值账户; 400:保证金账户; 101:收款码; 102:微信; 103:支付宝; 104:刷卡; 105:二维码台卡; 106:储值卡; 107:有赞E卡; 110:标记收款-自有微信支付; 111:标记收款-自有支付宝; 112:标记收款-自有POS刷卡; 113:通联刷卡支付; 200:记账账户; 201:现金
     */
    public $payType;
    /**
     * @var int 店铺类型 0:微商城; 1:微小店; 2:爱学贷微商城; 3:批发店铺; 4:批发商城; 5:外卖; 6:美业; 7:超级门店; 8:收银; 9:收银加微商城; 10:零售总部; 99:有赞开放平台平台型应用创建的店铺
     */
    public $teamType;
    /**
     * @var int 关闭类型 0:未关闭; 1:过期关闭; 2:标记退款; 3:订单取消; 4:买家取消; 5:卖家取消; 6:部分退款; 10:无法联系上买家; 11:买家误拍或重拍了; 12:买家无诚意完成交易; 13:已通过银行线下汇款; 14:已通过同城见面交易; 15:已通过货到付款交易; 16:已通过网上银行直接汇款; 17:已经缺货无法交易
     */
    public $closeType;
    /**
     * @var int 物流类型 0:快递发货; 1:到店自提; 2:同城配送; 9:无需发货（虚拟商品订单）
     */
    public $expressType;
    /**
     * @var OrderTags 订单打标
     */
    public $orderTags;
    /**
     * @var OrderExtra 订单扩展信息
     */
    public $orderExtra;
    /**
     * @var Carbon 订单创建时间
     */
    public $created;
    /**
     * @var Carbon 订单更新时间
     */
    public $updateTime;
    /**
     * @var Carbon 订单过期时间（未付款将自动关单）
     */
    public $expiredTime;
    /**
     * @var Carbon 订单支付时间
     */
    public $payTime;
    /**
     * @var Carbon 订单发货时间（当所有商品发货后才会更新）
     */
    public $consignTime;
    /**
     * @var Carbon 订单确认时间（多人拼团成团）
     */
    public $confirmTime;
    /**
     * @var int 退款状态 0:未退款; 1:部分退款中; 2:部分退款成功; 11:全额退款中; 12:全额退款成功
     */
    public $refundState;
    /**
     * @var bool 是否零售订单
     */
    public $isRetailOrder;
    /**
     * @var Carbon 订单成功时间
     */
    public $successTime;
    /**
     * @var int 网点id
     */
    public $offlineId;
    /**
     * @var string 支付类型。取值范围： WEIXIN (微信自有支付) WEIXIN_DAIXIAO (微信代销支付) ALIPAY (支付宝支付) BANKCARDPAY (银行卡支付) PEERPAY (代付) CODPAY (货到付款) BAIDUPAY (百度钱包支付) PRESENTTAKE (直接领取赠品) COUPONPAY(优惠券/码全额抵扣) BULKPURCHASE(来自分销商的采购) MERGEDPAY(合并付货款) ECARD(有赞E卡支付) PURCHASE_PAY (采购单支付) MARKPAY (标记收款) OFCASH (现金支付) PREPAIDCARD (储值卡余额支付)ENCHASHMENT_GIFT_CARD(礼品卡支付)
     */
    public $payTypeStr;

    public $dates = [
        'created',
        'update_time',
        'expired_time',
        'pay_time',
        'consign_time',
        'confirm_time',
        'success_time'
    ];

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \Exception
     */
    protected function parse() {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if (in_array($key, ['order_tags', 'order_extra'])) {
                $className = $convert->toPascal();
                if (class_exists($className) && property_exists(self::class, $propName)) {
                    $this->$propName = new $className($value);
                }
                continue;
            }
            if (in_array($key, $this->dates)) {
                $value = new Carbon($value);
            }
            $this->$propName = $value;
        }
    }
}