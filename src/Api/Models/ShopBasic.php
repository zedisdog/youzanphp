<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


class ShopBasic extends BaseModel
{
    /**
     * @var int 店铺ID
     */
    public $sid;
    /**
     * @var string 店铺名称
     */
    public $name;
    /**
     * @var string 店铺LOGO
     */
    public $logo;
    /**
     * @var string 店铺地址
     */
    public $url;
    /**
     * @var string 门店地址
     */
    public $physicalUrl;
    /**
     * @var int 认证类型（0 未认证 2 企业认证 3/4 个人认证 6/7/8/9 官方认证）
     */
    public $certType;
}