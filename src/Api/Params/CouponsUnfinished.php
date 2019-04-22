<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


class CouponsUnfinished extends BaseParams
{
    /**
     * @var string 需要返回的优惠对象字段。可选值：优惠结构体中所有字段均可返回；多个字段用“,”分隔。如果为空则返回所有
     */
    public $fields;

    public function __construct(string $fields = '')
    {
        $this->fields = $fields;
    }
}