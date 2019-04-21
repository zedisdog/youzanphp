<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class RemarkInfo extends BaseModel
{
    /**
     * @var string 订单买家留言
     */
    public $buyerMessage;
    /**
     * @var int 订单标星等级 0-5
     */
    public $star;
    /**
     * @var string 订单商家备注
     */
    public $tradeMemo;
}