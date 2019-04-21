<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

abstract class BaseModel
{
    public $raw;

    /**
     * BaseModel constructor.
     * @param $raw
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct($raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            $this->$propName = $value;
        }
    }
}