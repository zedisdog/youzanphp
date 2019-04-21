<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;

class ChildInfo extends BaseModel
{
    /**
     * @var string 送礼编号
     */
    public $giftNo;
    /**
     * @var string 送礼标记
     */
    public $giftSign;
    /**
     * @var ChildOrder[] 子单详情
     */
    public $childOrders;

    protected $lists = [
        'child_orders' => ChildOrder::class
    ];
}