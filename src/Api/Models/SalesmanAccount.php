<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


use Carbon\Carbon;
use Jawira\CaseConverter\Convert;

class SalesmanAccount extends BaseModel
{
    /**
     * @var string 手机号
     */
    public $mobile;
    /**
     * @var string 昵称
     */
    public $nickname;
    /**
     * @var string 分销员标识符
     */
    public $seller;
    /**
     * @var int 累计成交笔数
     */
    public $orderNum;
    /**
     * @var string 累计成交金额（元）
     */
    public $money;
    /**
     * @var Carbon 创建时间
     */
    public $createdAt;
    /**
     * @var string 邀请方手机号
     */
    public $fromBuyerMobile;
    /**
     * @var int 店铺自有粉丝id，绑定认证服务号的店铺才有
     */
    public $fansId;
    /**
     * @var int 分销员等级
     */
    public $level;

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \Exception
     */
    protected function parse()
    {
        foreach ($this->raw as $key => $value) {
            $convert = new Convert($key);
            $propName = $convert->toCamel();
            if ($key == 'created_at') {
                $value = new Carbon($value);
            }
            $this->$propName = $value;
        }
    }
}