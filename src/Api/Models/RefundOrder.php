<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class RefundOrder
{
    /**
     * @var int 退款类型 1:退款 - 买家申请退款; 2:退款 - 商家主动退款; 3:退款 - 一键退款
     */
    public $refundType;
    /**
     * @var int 退款金额
     */
    public $refundFee;
    /**
     * @var string 退款id
     */
    public $refundId;
    /**
     * @var int 退款状态 1:买家已经申请退款，等待卖家同意; 10:卖家拒绝退款; 20:卖家已经同意退货，等待买家退货; 30:买家已经退货，等待卖家确认收货; 40:卖家未收到货,拒绝退款; 50:退款关闭; 60:退款成功;
     */
    public $refundState;
    /**
     * @var string[] 退款交易明细
     */
    public $oids;

    public $raw;

    /**
     * RefundOrder constructor.
     * @param array $raw
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if ($key == 'refund_fee') {
                $value = intval($value * 100);
            }
            $this->$propName = $value;
        }
    }
}