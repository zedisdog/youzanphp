<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class Category extends BaseModel
{
    /**
     * @var int 类目ID
     */
    public $cid;
    /**
     * @var int 父的类目ID（当前类目是顶级类目时parentCid=0）
     */
    public $parentCid;
    /**
     * @var string 类目名称
     */
    public $name;
    /**
     * @var bool 是否是一级类目（对应class1）
     */
    public $isParent;
    /**
     * @var array 子类目
     */
    public $subCategories;

    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if ($key == 'sub_categories') {
                $tmp = [];
                foreach ($value as $item) {
                    array_push($tmp, new self($item));
                }
                $value = $tmp;
            }
            $this->$propName = $value;
        }
    }
}