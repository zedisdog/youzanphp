<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;
use Jawira\CaseConverter\Convert;

abstract class BaseModel
{
    public $raw;
    protected $dates = [];
    protected $prices = [];
    protected $customerConverts = [];
    protected $lists = [];
    protected $objects = [];
    protected $booleans = [];

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
     * @throws \Exception
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if (in_array($key, $this->dates) && $value) {
                if (is_numeric($value)) {
                    $value = Carbon::createFromTimestamp(intval($value/100));
                } else {
                    $value = new Carbon($value);
                }
            } else {
                $value = null;
            }
            if (in_array($key, $this->prices)) {
                $value = intval($value * 100);
            }
            if (in_array($key, $this->booleans)) {
                if(is_string($value)) {
                    $value = $value == "true" ? true : false;
                } else {
                    $value = boolval($value);
                }
            }
            if (array_key_exists($key, $this->customerConverts)) {
                if (is_callable($this->customerConverts[$key])) {
                    $value = $this->customerConverts[$key]($value);
                } else {
                    $value = $this->customerConverts[$key];
                }
            }
            if (array_key_exists($key, $this->lists)) {
                if (is_array($this->lists[$key])) {
                    $propName = $this->lists[$key]['propName'];
                    $value = $this->parseList($value, $this->lists[$key]['class']);
                } else {
                    $value = $this->parseList($value, $this->lists[$key]);
                }
            }
            if (array_key_exists($key, $this->objects)) {
                $value = $this->parseObject($value, $this->objects[$key]);
            }
            $this->$propName = $value;
        }
    }

    protected function parseList(array $value, string $class)
    {
        $tmp = [];
        foreach ($value as $v) {
            array_push($tmp, new $class($v));
        }
        return $tmp;
    }

    protected function parseObject(array $value, string $class)
    {
        return new $class($value);
    }
}