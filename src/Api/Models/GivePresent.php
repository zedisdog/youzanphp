<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


class GivePresent extends BaseModel
{
    /**
     * @var bool 是否领取成功
     */
    public $isSuccess;
    /**
     * @var int 赠品ID
     */
    public $presentId;
    /**
     * @var string 赠品名
     */
    public $presentName;
    /**
     * @var string 赠品领取链接
     */
    public $receiveAddress;
}