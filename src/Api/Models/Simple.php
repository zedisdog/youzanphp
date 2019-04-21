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

    public function __construct($raw)
    {
        $this->customerConverts = [
            'is_success' => function($value) {
                if (is_string($value)) {
                    return $value == 'true' ? true : false;
                } else {
                    return boolval($value);
                }
            }
        ];
        parent::__construct($raw);
    }
}