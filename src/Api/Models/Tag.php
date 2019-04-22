<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class Tag extends BaseModel
{
    /**
     * @var int 商品标签ID
     */
    public $id;
    /**
     * @var string 商品标签名称
     */
    public $name;
    /**
     * @var int 商品标签类型。0：自定义；1：未分类；2：最新；3：最热；4：隐藏
     */
    public $type;
    /**
     * @var Carbon 商品标签创建时间
     */
    public $created;
    /**
     * @var int 商品标签内的商品数量
     */
    public $itemNum;
    /**
     * @var string 商品标签展示的URL地址
     */
    public $tagUrl;
    /**
     * @var string 分享出去的商品标签展示地址
     */
    public $shareUrl;
    /**
     * @var string 商品标签描述
     */
    public $desc;

    protected $dates = [
        'created'
    ];
}