<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


use Dezsidog\Youzanphp\Contract\Params;

class IncreasePoint implements Params
{
    /**
     * @var string
     */
    public $account_id;
    /**
     * @var int
     */
    public $account_type;
    /**
     * @var int
     */
    public $points;
    /**
     * @var string
     */
    public $biz_value;
    /**
     * @var string
     */
    public $reason;

    public function __construct(string $accountId, int $accountType, int $points, string $reason, string $bizValue = '')
    {
        $this->account_id = $accountId;
        $this->account_type = $accountType;
        $this->points = $points;
        $this->reason = $reason;
        $this->biz_value = $bizValue;
    }

    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this);
    }
}