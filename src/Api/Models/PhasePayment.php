<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class PhasePayment extends BaseModel
{
    /**
     * @var int 支付阶段
     */
    public $phase;
    /**
     * @var Carbon 支付开始时间
     */
    public $payStartTime;
    /**
     * @var Carbon 支付结束时间
     */
    public $payEndTime;
    /**
     * @var int 阶段支付金额
     */
    public $realPrice;
    /**
     * @var string 外部支付流水号
     */
    public $outerTransactionNo;
    /**
     * @var string 内部支付流水号
     */
    public $innerTransactionNo;

    protected $dates = [
        'pay_start_time',
        'pay_end_time'
    ];
    protected $prices = [
        'real_price'
    ];
}