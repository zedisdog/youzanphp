<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


use Dezsidog\Youzanphp\Contract\Params;

class SalesmanAccount implements Params
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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}