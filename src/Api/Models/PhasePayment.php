<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;

class PhasePayment
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

    public $raw;

    /**
     * PhasePayment constructor.
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
    protected function parse() {
        $this->phase = $this->raw['phase'];
        $this->payStartTime = new Carbon($this->raw['pay_start_time']);
        $this->payEndTime = new Carbon($this->raw['pay_end_time']);
        $this->realPrice = intval($this->raw['real_price'] * 100);
        $this->outerTransactionNo = $this->raw['outer_transaction_no'];
        $this->innerTransactionNo = $this->raw['inner_transaction_no'];
    }

}