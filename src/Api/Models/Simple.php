<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class Simple
{
    /**
     * @var bool
     */
    public $isSuccess;

    public $raw;

    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

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