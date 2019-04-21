<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class Shop extends BaseModel
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $logo;
    /**
     * @var string
     */
    public $intro;
}