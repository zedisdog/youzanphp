<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class Source
{
    /**
     * @var string 平台 wx:微信; merchant_3rd:商家自有app; buyer_v:买家版; browser:系统浏览器; alipay:支付宝;qq:腾讯QQ; wb:微博; other:其他
     */
    public $platform;

    /**
     * @var string 微信平台细分 wx_gzh:微信公众号; yzdh:有赞大号; merchant_xcx:商家小程序; yzdh_xcx:有赞大号小程序; direct_buy:直接购买
     */
    public $wxEntrance;

    public $raw;

    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    protected function parse()
    {
        $this->platform = $this->raw['platform'];
        $this->wxEntrance = $this->raw['wx_entrance'];
    }
}