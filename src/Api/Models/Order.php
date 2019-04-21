<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class Order extends BaseModel
{
    /**
     * @var string 订单明细id
     */
    public $oid;
    /**
     * @var int 订单类型 0:普通类型商品; 1:拍卖商品; 5:餐饮商品; 10:分销商品; 20:会员卡商品; 21:礼品卡商品; 23:有赞会议商品; 24:周期购; 30:收银台商品; 31:知识付费商品; 35:酒店商品; 40:普通服务类商品; 182:普通虚拟商品; 183:电子卡券商品; 201:外部会员卡商品; 202:外部直接收款商品; 203:外部普通商品; 205:mock不存在商品; 206:小程序二维码
     */
    public $itemType;
    /**
     * @var string 商品名称
     */
    public $title;
    /**
     * @var int 商品数量
     */
    public $num;
    /**
     * @var string 商家编码
     */
    public $outerSkuId;
    /**
     * @var string 商品留言
     */
    public $buyerMessages;
    /**
     * @var int 单商品原价
     */
    public $price;
    /**
     * @var int 商品优惠后总价
     */
    public $totalFee;
    /**
     * @var int 商品最终均摊价
     */
    public $payment;
    /**
     * @var int 商品id
     */
    public $itemId;
    /**
     * @var int 规格id（无规格商品为0）
     */
    public $skuId;
    /**
     * @var string 规格信息（无规格商品为空）
     */
    public $skuPropertiesName;
    /**
     * @var string 商品编码
     */
    public $outerItemId;
    /**
     * @var string 商品积分价（非积分商品则为0）
     */
    public $pointsPrice;
    /**
     * @var string 商品图片地址
     */
    public $picPath;
    /**
     * @var string 商品详情链接
     */
    public $goodsUrl;
    /**
     * @var string 商品别名
     */
    public $alias;
    /**
     * @var bool 是否赠品
     */
    public $isPresent;
    /**
     * @var int 单商品现价，减去了商品的优惠金额
     */
    public $discountPrice;
    /**
     * @var string 商品唯一编码
     */
    public $skuUniqueCode;
    /**
     * @var string 0 全款预售，1 定金预售
     */
    public $preSaleType;
    /**
     * @var string 是否为预售商品 如果是预售商品则为1
     */
    public $isPreSale;
    /**
     * @var string 是否是跨境海淘订单("1":是,"0":否)
     */
    public $isCrossBorder;
    /**
     * @var string 海关编号
     */
    public $customsCode;
    /**
     * @var string 海淘商品贸易模式
     */
    public $crossBorderTradeMode;
    /**
     * @var string 子订单号
     */
    public $subOrderNo;
    /**
     * @var int 分销单金额 ，单位元
     */
    public $fenxiaoPrice;
    /**
     * @var int 分销单实付金额 ，单位元
     */
    public $fenxiaoPayment;

    protected $prices = [
        'price',
        'total_fee',
        'payment',
        'discount_price',
        'fenxiao_price',
        'fenxiao_payment'
    ];
}