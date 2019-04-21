<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

/**
 * Class FullOrderInfo
 * @package Dezsidog\Youzanphp\Client\Models
 */
class FullOrderInfo extends BaseModel
{
    /**
     * @var OrderInfo
     */
    public $orderInfo;
    /**
     * @var SourceInfo
     */
    public $sourceInfo;
    /**
     * @var BuyerInfo
     */
    public $buyerInfo;
    /**
     * @var PayInfo
     */
    public $payInfo;
    /**
     * @var RemarkInfo
     */
    public $remarkInfo;
    /**
     * @var AddressInfo
     */
    public $addressInfo;
    /**
     * @var Order[]
     */
    public $orders;
    /**
     * @var ChildInfo
     */
    public $child_info;

    protected $lists = [
        'orders' => Order::class
    ];

    protected $objects = [
        'order_info' => OrderInfo::class,
        'source_info' => SourceInfo::class,
        'buyer_info' => BuyerInfo::class,
        'pay_info' => PayInfo::class,
        'remark_info' => RemarkInfo::class,
        'address_info' => AddressInfo::class,
        'child_info' => ChildInfo::class
    ];
}