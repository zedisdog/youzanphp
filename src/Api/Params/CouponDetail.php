<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


class CouponDetail extends BaseParams
{
    /**
     * @var int 	优惠活动ID
     */
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}