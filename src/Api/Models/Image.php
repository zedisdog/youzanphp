<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class Image extends BaseModel
{
    /**
     * @var string 图片链接地址
     */
    public $url;
    /**
     * @var string 图片缩略图链接地址
     */
    public $thumbnail;
    /**
     * @var string 中号大小图片链接地址
     */
    public $medium;
    /**
     * @var string 组合图片链接地址
     */
    public $combine;
    /**
     * @var Carbon 创建是时间
     */
    public $created;
    /**
     * @var int 图片ID
     */
    public $id;

    protected $dates = [
        'created'
    ];
}