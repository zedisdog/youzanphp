<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class PayInfo extends BaseModel
{
    /**
     * @var int 优惠前商品总价
     */
    public $totalFee;
    /**
     * @var int 邮费
     */
    public $postFee;
    /**
     * @var int 最终支付价格 payment=orders.payment的总和
     */
    public $payment;
    /**
     * @var string[] 有赞支付流水号
     */
    public $transaction;
    /**
     * @var string[] 外部支付单号
     */
    public $outerTransactions;
    /**
     * @var PhasePayment[] 多阶段支付信息
     */
    public $phasePayments;

    protected $lists = [
        'phase_payments' => PhasePayment::class
    ];
}