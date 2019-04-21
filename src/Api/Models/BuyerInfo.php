<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class BuyerInfo extends BaseModel
{
    /**
     * @var int 买家id
     */
    public $buyerId;
    /**
     * @var string 买家手机号
     */
    public $buyerPhone;
    /**
     * @var int 粉丝类型 1:自有粉丝; 9:代销粉丝
     */
    public $fansType;
    /**
     * @var int 粉丝id
     */
    public $fansId;
    /**
     * @var string 粉丝昵称
     */
    public $fansNickname;
    /**
     * @var string 微信H5和微信小程序（有赞小程序和小程序插件）的订单会返回微信weixin_openid，三方App（有赞APP开店）的订单会返回open_user_id，2019年1月30号后的订单支持返回该参数
     */
    public $outerUserId;
}