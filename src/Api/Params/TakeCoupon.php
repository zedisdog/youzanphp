<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


class TakeCoupon extends BaseParams
{
    const WEIXIN_OPENID = 'weixin_openid';
    const OPEN_USER_ID = 'open_user_id';
    const MOBILE = 'mobile';
    const FANS_ID = 'fans_id';
    /**
     * @var int 优惠券/码活动ID
     */
    public $coupon_group_id;
    /**
     * @var string mobile，weixin_openid，fans_id，open_user_id任传一个即可
     */
    public $identify;
    /**
     * @var string 类型
     */
    public $type;

    public function __construct(int $couponGroupId, string $identify, string $type)
    {
        $this->coupon_group_id = $couponGroupId;
        $this->identify = $identify;
        $this->type = $type;
    }

    public function __toString(): string
    {
        $data = [
            'coupon_group_id' => $this->coupon_group_id,
        ];
        $data[$this->type] = $this->identify;

        return \GuzzleHttp\json_encode($data);
    }
}