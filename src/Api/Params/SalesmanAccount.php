<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;

class SalesmanAccount extends BaseParams
{
    /**
     * @var int
     */
    public $fans_type;
    /**
     * @var int
     */
    public $fans_id;
    /**
     * @var string
     */
    public $mobile;

    public function __construct(int $fansType, int $fansId, string $mobile)
    {
        $this->fans_type = $fansType;
        $this->fans_id = $fansId;
        $this->mobile = $mobile;
    }
}