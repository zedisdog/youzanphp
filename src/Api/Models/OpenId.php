<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class OpenId extends BaseModel
{
    /**
     * @var string
     */
    public $openId;

    /**
     * @var string
     */
    public $unionId;
}