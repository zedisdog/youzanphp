<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;
use Jawira\CaseConverter\Convert;

class AddressInfo extends BaseModel
{
    /**
     * @var string 收货人姓名
     */
    public $receiverName;
    /**
     * @var string 收货人手机号
     */
    public $receiverTel;
    /**
     * @var string 省
     */
    public $deliveryProvince;
    /**
     * @var string 市
     */
    public $deliveryCity;
    /**
     * @var string 区
     */
    public $deliveryDistrict;
    /**
     * @var string 详细地址
     */
    public $deliveryAddress;
    /**
     * @var string 字段为json格式，需要开发者自行解析 lng、lon（经纬度）； checkOutTime（酒店退房时间）； recipients（入住人）； checkInTime（酒店入住时间）； idCardNumber（海淘身份证信息）； areaCode（邮政编码）
     */
    public $addressExtra;
    /**
     * @var string 邮政编码
     */
    public $deliveryPostalCode;
    /**
     * @var string 到店自提信息 json格式
     */
    public $selfFetchInfo;
    /**
     * @var Carbon 同城送预计送达时间-开始时间 非同城送以及没有开启定时达的订单不返回
     */
    public $deliveryStartTime;
    /**
     * @var Carbon 同城送预计送达时间-结束时间 非同城送以及没有开启定时达的订单不返回
     */
    public $deliveryEndTime;

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \Exception
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if (in_array($key, ['delivery_start_time', 'delivery_end_time'])) {
                $value = new Carbon($value);
            }
            $this->$propName = $value;
        }
    }

}