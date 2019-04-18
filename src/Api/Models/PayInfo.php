<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class PayInfo
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

    public $raw;

    /**
     * PayInfo constructor.
     * @param array $raw
     * @throws \Exception
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    /**
     * @throws \Exception
     */
    protected function parse()
    {
        $this->totalFee = intval($this->raw['total_fee'] * 100);
        $this->postFee = intval($this->raw['post_fee'] * 100);
        $this->payment = intval($this->raw['payment'] * 100);
        $this->transaction = $this->raw['transaction'];
        $this->outerTransactions = $this->raw['outer_transactions'];
        $this->phasePayments = [];
        foreach ($this->raw['phase_payments'] as $item) {
            array_push($this->phasePayments, new PhasePayment($item));
        }
    }
}