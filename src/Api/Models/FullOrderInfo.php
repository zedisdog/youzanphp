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
class FullOrderInfo
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

    public $raw;

    /**
     * FullOrderInfo constructor.
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
            if ($key == 'orders') {
                $this->orders = [];
                foreach ($value as $item) {
                    array_push($this->orders, new Order($item));
                }
            } else {
                $convert = new Convert($key);
                $className = $convert->toPascal();
                $propName = $convert->toCamel();
                if (class_exists($className) && property_exists(self::class, $propName)) {
                    $this->$propName = new $className($value);
                }
            }
        }
    }


}