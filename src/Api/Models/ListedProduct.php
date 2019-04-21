<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;
use Jawira\CaseConverter\Convert;

class ListedProduct extends BaseModel
{
    /**
     * @var string 默认值"youzan_goods_selling"
     */
    public $classId;
    /**
     * @var string 商品图片链接
     */
    public $image;
    /**
     * @var string 商品图片链接和image字段内容一致
     */
    public $shareIcon;
    /**
     * @var string 商品名
     */
    public $shareTitle;
    /**
     * @var int 商品价格和price值一致，单位:分
     */
    public $shareDetail;
    /**
     * @var int 商品ID 微商城店铺下商品唯一标识。
     */
    public $itemId;
    /**
     * @var string 商品别名 微商城店铺下商品唯一标识。
     */
    public $alias;
    /**
     * @var string 商品小程序访问地址
     */
    public $pageUrl;
    /**
     * @var string 商品名
     */
    public $title;
    /**
     * @var int 商品价格 单位:分
     */
    public $price;
    /**
     * @var int 商品类型： 0—普通商品 3—UMP降价拍 5—外卖商品 10—分销商品 20—会员卡商品 21—礼品卡商品 22—团购券 25—批发商品 30—收银台商品 31—知识付费商品 35—酒店商品 40—美业商品 60—虚拟商品 61—电子卡券
     */
    public $itemType;
    /**
     * @var string 商品编码，商家可以自定义参数，支持英文和数据组合。商家为商品设置的外部编号，可与商家外部系统对接
     */
    public $itemNo;
    /**
     * @var int 总库存
     */
    public $quantity;
    /**
     * @var int 运费类型，1是统一运费，2是运费模板
     */
    public $postType;
    /**
     * @var int 运费 单位：分
     */
    public $postFee;
    /**
     * @var Carbon 创建时间
     */
    public $createdTime;
    /**
     * @var Carbon 更新时间
     */
    public $updatedTime;
    /**
     * @var string 商品详情链接
     */
    public $detailUrl;
    /**
     * @var int 商家排序字段
     */
    public $num;
    /**
     * @var DeliveryTemplate 运费模板
     */
    public $deliveryTemplate;
    /**
     * @var Image[] 图片信息
     */
    public $itemImgs;
    /**
     * @var int 划线价 单位：分
     */
    public $origin;
    /**
     * @var string 分享描述
     */
    public $subTitle;

    protected $dates = [
        'created_time',
        'updated_time'
    ];

    protected $prices = [
        'origin'
    ];

    protected $lists = [
        'item_imgs' => Image::class
    ];

    protected $objects = [
        'delivery_template' => DeliveryTemplate::class
    ];
}