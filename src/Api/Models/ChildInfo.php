<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class ChildInfo
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

    public $raw;

    /**
     * ChildInfo constructor.
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
        $this->giftNo = $this->raw['gift_no'];
        $this->giftSign = $this->raw['gift_sign'];
        $this->childOrders = [];
        foreach ($this->childOrders as $item) {
            array_push($this->childOrders, new ChildOrder($item));
        }
    }
}