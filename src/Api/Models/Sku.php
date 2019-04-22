<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class Sku extends BaseModel
{
    /**
     * @var string 商家编码（商家为sku设置的外部编号）
     */
    public $outerId;
    /**
     * @var int 商品规格ID，sku_id 在系统里并不是唯一的，结合商品ID一起使用才是唯一的
     */
    public $skuId;
    /**
     * @var string sku在系统中的唯一编号，可以在开发者的系统中用作 sku 的唯一ID，但不能用于调用接口
     */
    public $skuUniqueCode;
    /**
     * @var int Sku所属商品的id
     */
    public $numIid;
    /**
     * @var int 属于这个sku的商品的数量
     */
    public $quantity;
    /**
     * @var string sku所对应的销售属性的中文名字串，格式如：pid1:vid1:pid_name1:vid_name1;pid2:vid2:pid_name2:vid_name2……
     */
    public $propertiesName;
    /**
     * @var string sku所对应的销售属性的Json字符串（需另行解析）， 该字段内容与properties_name字段除了格式不一样，内容完全一致。 由于产品规格信息难以避免涉及到‘:’、‘,’、‘;’这些与解析规则冲突的字符，所以增加该字段。 </br>格式定义： <pre> [ { "kid": "20000", "vid": "3275069", "k": "品牌", "v": "盈讯" }, { "kid": "1753146", "vid": "3485013", "k": "型号", "v": "F908" } .....
     */
    public $propertiesNameJson;
    /**
     * @var int 商品在付款减库存的状态下，该sku上未付款的订单数量
     */
    public $withHoldQuantity;
    /**
     * @var int 商品的这个sku的价格；精确到2位小数；单位：分
     */
    public $price;
    /**
     * @var Carbon sku创建日期
     */
    public $created;
    /**
     * @var Carbon sku最后修改日期
     */
    public $modified;
    /**
     * @var bool sku库存是否锁定。0：未锁定；1：锁定
     */
    public $stockLocked;

    protected $dates = [
        'created',
        'modified',
    ];

    protected $prices = [
        'price',
    ];

    protected $booleans = [
        'stockLocked'
    ];
}