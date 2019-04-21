<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;

class DeliveryTemplate extends BaseModel
{
    /**
     * @var int 运费模板ID，在物流API列表，使用youzan.logistics.template.search获取店铺所有模板列表接口运费模板id详情。
     */
    public $deliveryTemplateId;
    /**
     * @var int 运费范围 单位:分
     */
    public $deliveryTemplateFee;
    /**
     * @var string 运费模板名称
     */
    public $deliveryTemplateName;
    /**
     * @var int 运费计费类型 1—按件计费 2—按重量计费 3—体积计费
     */
    public $deliveryTemplateValuationType;

    protected $prices = [
        'delivery_template_fee'
    ];
}