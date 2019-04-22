<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class PresentItem extends BaseModel
{
    /**
     * @var int 商品id
     */
    public $numId;
    /**
     * @var string 商品别名
     */
    public $alias;
    /**
     * @var string 商品标题
     */
    public $title;
    /**
     * @var int 商品分类的叶子类目id
     */
    public $cid;
    /**
     * @var int 商品推广栏目id
     */
    public $promotionCid;
    /**
     * @var string 商品标签id串，结构如：1234,1342,...
     */
    public $tagIds;
    /**
     * @var string 商品描述
     */
    public $desc;
    /**
     * @var int 显示在“原价”一栏中的信息
     */
    public $originPrice;
    /**
     * @var string 商品货号（商家为商品设置的外部编号，可与商家外部系统对接）
     */
    public $outerId;
    /**
     * @var string 商品外部购买链接
     */
    public $outerBuyUrl;
    /**
     * @var int 每人限购多少件。0代表无限购，默认为0
     */
    public $buyQuota;
    /**
     * @var Carbon 商品发布时间
     */
    public $created;
    /**
     * @var bool 是否为虚拟商品
     */
    public $isVirtual;
    /**
     * @var int 普通商品0，电子卡券3
     */
    public $virtualType;
    /**
     * @var Carbon 长期有效，留空；非空表示自定义有效期的开始时间*
     */
    public $itemValidityStart;
    /**
     * @var Carbon 长期有效，留空；非空表示自定义有效期的结束时间*
     */
    public $itemValidityEnd;
    /**
     * @var int 电子凭证生效类型。0：立即生效； 1：自定义推迟时间；2：隔天生效
     */
    public $effectiveType;
    /**
     * @var int 电子凭证自定义推迟时间
     */
    public $effectiveDelayHours;
    /**
     * @var bool 节假日是否可用*
     */
    public $holidaysAvalable;
    /**
     * @var bool 商品上架状态。true 为已上架，false 为已下架
     */
    public $isListing;
    /**
     * @var bool 商品是否锁定。true 为已锁定，false 为未锁定
     */
    public $isLock;
    /**
     * @var bool 是否为二手商品
     */
    public $isUsed;
    /**
     * @var int 商品类型。0：普通商品；10：分销商品 *
     */
    public $productType;
    /**
     * @var Carbon 商品定时上架（定时开售）的时间。没设置则为0
     */
    public $autoListingTime;
    /**
     * @var string 适合wap应用的商品详情url
     */
    public $detailUrl;
    /**
     * @var string 分享出去的商品详情url
     */
    public $shareUrl;
    /**
     * @var string 商品主图片地址
     */
    public $picUrl;
    /**
     * @var string 商品主图片缩略图地址
     */
    public $picThumbUrl;
    /**
     * @var int 商品数量
     */
    public $num;
    /**
     * @var int 商品销量
     */
    public $soldNum;
    /**
     * @var int 商品价格，格式：500；单位：分；精确到：分*
     */
    public $price;
    /**
     * @var int 运费类型。1：统一邮费；2：运费模版
     */
    public $postType;
    /**
     * @var int 运费（针对“统一运费”），格式：500；单位：分；精确到：分
     */
    public $postFee;
    /**
     * @var int 运费（针对“运费模版”），格式：500；单位：分；精确到：分。若存在运费区间，中间用逗号隔开，如 “5.00,9.00”
     */
    public $deliveryTemplateFee;
    /**
     * @var int 运费模版id
     */
    public $deliveryTemplateId;
    /**
     * @var string 运费模版名称
     */
    public $deliveryTemplateName;
    /**
     * @var Sku[] sku数据结构
     */
    public $skus;
    /**
     * @var Image[] 商品图片数据结构
     */
    public $itemImgs;
    /**
     * @var QrCode[] 商品二维码数据结构
     */
    public $itemQrcodes;
    /**
     * @var Tag[] 商品标签数据结构
     */
    public $itemTags;
    /**
     * @var int 商品类型。0：普通商品；10：分销商品
     */
    public $itemType;
    /**
     * @var bool 是否供货商商品
     */
    public $isSupplierItem;
    /**
     * @var int 商品点赞数
     */
    public $likeCount;
    /**
     * @var int 模板id
     */
    public $templateId;
    /**
     * @var string 模板名称
     */
    public $templateTitle;
    /**
     * @var bool 是否参加会员折扣*
     */
    public $joinLevelDiscount;
    /**
     * @var int 商品序号
     */
    public $order;
    /**
     * @var bool 是否设置商品购买权限*
     */
    public $purchaseRight;
    /**
     * @var int 商品库存是否锁定。0：未锁定；1：锁定，如果商品有SKU该字段恒为0
     */
    public $stockLocked;

    protected $lists = [
        'skus' => Sku::class,
        'item_imgs' => Image::class,
        'item_qrcodes' => QrCode::class,
        'item_tags' => Tag::class
    ];

    protected $dates = [
        'created',
        'item_validity_start',
        'item_validity_end',
        'auto_listing_time',
    ];

    protected $prices = [
        'delivery_template_fee',
        'post_fee',
        'price',
        'origin_price'
    ];

    protected $booleans = [
        'is_virtual',
        'holidays_avalable',
        'is_used',
        'is_supplier_item',
        'join_level_discount',
        'purchase_right',
    ];
}