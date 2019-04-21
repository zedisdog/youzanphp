<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class Simple extends BaseModel
{
    /**
     * @var bool
     */
    public $isSuccess;

    protected function parse()
    {
        $isSuccess = $this->raw['is_success'];
        if (is_string($isSuccess)) {
            $this->isSuccess = $isSuccess == 'true' ? true : false;
        } else {
            $this->isSuccess = boolval($isSuccess);
        }
    }
}