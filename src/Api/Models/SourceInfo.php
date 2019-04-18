<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Jawira\CaseConverter\Convert;

class SourceInfo
{
    /**
     * @var bool 是否来自线下订单
     */
    public $isOfflineOrder;
    /**
     * @var Source 平台
     */
    public $source;
    /**
     * @var string 订单标记 wx_apps:微信小程序买家版 wx_shop:微信小程序商家版 wx_wm:微信小程序外卖 wap_wm:移动端外卖 super_store:超级门店 weapp_spotlight:新微信小程序买家版 wx_meiye:美业小程序 wx_apps_maidan:小程序餐饮买单 wx_apps_diancan:小程序堂食 weapp_youzan:有赞小程序 retail_free_buy:零售自由购 weapp_owl:知识付费小程序 app_spotlight:有赞精选app retail_scan_buy:零售扫码购 weapp_plugin:小程序插件 除以上之外为其他
     */
    public $orderMark;
    /**
     * @var string 订单唯一识别码
     */
    public $bookKey;
    /**
     * @var string 活动类型：如群团购：”mall_group_buy“
     */
    public $bizSource;
    public $raw;

    /**
     * SourceInfo constructor.
     * @param array $raw
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct(array $raw)
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
            if ($key == 'source') {
                $className = $convert->toPascal();
                if (class_exists($className) && property_exists(self::class, $propName)) {
                    $this->$propName = new $className($value);
                }
            } else {
                $this->$propName = $value;
            }
        }
    }

}