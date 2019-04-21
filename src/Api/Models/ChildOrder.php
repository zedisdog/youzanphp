<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class ChildOrder extends BaseModel
{
    /**
     * @var string 订单号
     */
    public $tid;
    /**
     * @var string 领取人姓名
     */
    public $userName;
    /**
     * @var string 领取人电话
     */
    public $userTel;
    /**
     * @var string 省
     */
    public $province;
    /**
     * @var string 市
     */
    public $city;
    /**
     * @var string 区
     */
    public $county;
    /**
     * @var string 收货地址详情
     */
    public $addressDetail;
    /**
     * @var string 老送礼订单状态：WAIT_EXPRESS(5, "待发货"), EXPRESS(6, "已发货"), SUCCESS(100, "成功")
     */
    public $orderState;
}