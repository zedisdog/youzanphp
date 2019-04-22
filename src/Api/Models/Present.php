<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class Present extends BaseModel
{
    /**
     * @var int 赠品ID
     */
    public $presentId;
    /**
     * @var string 赠品标题
     */
    public $title;
    /**
     * @var Carbon 赠品生效时间
     */
    public $startAt;
    /**
     * @var Carbon 赠品结束时间
     */
    public $endAt;
    /**
     * @var int 领取限制，每个人限领多少个，必须大于0
     */
    public $fetchLimit;
    /**
     * @var PresentItem 商品数据结构
     */
    public $item;
    /**
     * @var Carbon 赠品创建时间
     */
    public $created;

    protected $objects = [
        'item' => PresentItem::class
    ];

    protected $dates = [
        'start_at',
        'end_at',
        'created'
    ];
}