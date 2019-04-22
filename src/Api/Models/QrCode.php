<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class QrCode extends BaseModel
{
    /**
     * @var int 商品二维码的ID
     */
    public $id;
    /**
     * @var string 二维码的名称
     */
    public $name;
    /**
     * @var string 二维码的描述
     */
    public $desc;
    /**
     * @var Carbon 商品二维码创建时间
     */
    public $created;
    /**
     * @var string 商品二维码类型。可选值：GOODS_SCAN_FOLLOW(扫码关注后购买商品) ；GOODS_SCAN_FOLLOW_DECREASE(扫码关注后减优惠额) ；GOODS_SCAN_FOLLOW_DISCOUNT(扫码关注后折扣) ；GOODS_SCAN_DECREASE(扫码直接减优惠额) ； GOODS_SCAN_DISCOUNT(扫码直接折扣)
     */
    public $type;
    /**
     * @var string 折扣，格式：9.0；单位：折，精确到小数点后 1 位。如果没有折扣，则为 0
     */
    public $discount;
    /**
     * @var int 减金额优惠，格式：500；单位：分；精确到：分。如果没有减额优惠，则为 0
     */
    public $decrease;
    /**
     * @var string 扫码直接购买的二维码基于这个url生成。如果不是扫码直接购买的类型，则为空
     */
    public $linkUrl;
    /**
     * @var string 扫码关注购买的二维码图片地址。如果不是扫码关注购买的类型，则为空
     */
    public $weixinQrcodeUrl;

    protected $prices = [
        'decrease'
    ];

    protected $dates = [
        'created'
    ];
}