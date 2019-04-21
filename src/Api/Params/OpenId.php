<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Params;


class OpenId extends BaseParams
{
    /**
     * @var string 手机号
     */
    public $mobile;

    /**
     * @var string 手机号国际码
     */
    public $country_code;

    public function __construct(string $mobile, string $countryCode = '86')
    {
        $this->mobile = $mobile;
        $this->country_code = $countryCode;
    }
}