<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class OrderExtra extends BaseModel
{
    /**
     * @var bool 是否来自购物车 是：true 不是：false
     */
    public $isFromCart;
    /**
     * @var string 收银员id
     */
    public $cashierId;
    /**
     * @var string 收银员名字
     */
    public $cashierName;
    /**
     * @var string 发票抬头
     */
    public $invoiceTitle;
    /**
     * @var string 结算时间
     */
    public $settleTime;
    /**
     * @var bool 是否父单(分销合并订单) 是：true 其他：false
     */
    public $isParentOrder;
    /**
     * @var bool 是否子单(分销买家订单) 是：true 其他：false
     */
    public $isSubOrder;
    /**
     * @var string 分销单订单号
     */
    public $fxOrderNo;
    /**
     * @var string 分销店铺id
     */
    public $fxKdtId;
    /**
     * @var string 父单号
     */
    public $parentOrderNo;
    /**
     * @var string 采购单订单号
     */
    public $purchaseOrderNo;
    /**
     * @var string 美业分店id
     */
    public $deptId;
    /**
     * @var string 下单设备号
     */
    public $createDeviceId;
    /**
     * @var bool 是否是积分订单：true：是 false：不是
     */
    public $isPointsOrder;
    /**
     * @var string 海淘身份证信息：332527XXXXXXXXX
     */
    public $idCardNumber;
    /**
     * @var string 下单人昵称
     */
    public $buyerName;
    /**
     * @var bool 是否会员订单
     */
    public $isMember;
    /**
     * @var int 团购返现优惠金额
     */
    public $tmCash;
    /**
     * @var int 团购返现最大返现金额
     */
    public $tCash;
    /**
     * @var int 订单返现金额
     */
    public $cash;
    /**
     * @var string 虚拟总单号：一次下单发生拆单时，会生成一个虚拟总单号
     */
    public $ordersCombineId;
    /**
     * @var string 拆单时店铺维度的虚拟总单号：发生拆单时，单个店铺生成了多笔订单会生成一个店铺维度的虚拟总单号
     */
    public $kdtDimensionCombineId;
    /**
     * @var string 使用了同一张优惠券&优惠码的多笔订单对应的虚拟总单号
     */
    public $promotionCombineId;
    /**
     * @var string 身份证姓名信息 （订购人的身份证号字段可通过订单详情4.0接口“id_card_number ”获取）
     */
    public $idCardName;
    /**
     * @var string 分销单外部支付流水号
     */
    public $fxOuterTransactionNo;
    /**
     * @var string 分销单内部支付流水号
     */
    public $fxInnerTransactionNo;

    public $beSure = [
        'is_from_cart',
        'is_parent_order',
        'is_sub_order',
        'is_member',
    ];

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if (in_array($key, $this->beSure)) {
                if(is_string($value)) {
                    $value = (strtolower($value) == "true" || $value == '1') ? true : false;
                } else {
                    $value = boolval($value);
                }
            }
            $this->$propName = $value;
        }
    }
}