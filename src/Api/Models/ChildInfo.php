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