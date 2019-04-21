<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class ExpressInfo extends BaseModel
{
    /**
     * @var int 物流类型
     */
    public $expressId;
    /**
     * @var string 物流编号
     */
    public $expressNo;
}