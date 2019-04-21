<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Params;

use Dezsidog\Youzanphp\Exceptions\BadTagParam;

class AddTag extends BaseParams
{
    /**
     * @var string 帐号类型。目前支持以下选项（只支持传一种）： FansID：自有粉丝ID， Mobile：手机号， YouZanAccount：有赞账号，OpenUserId：三方自身账号， WeiXinOpenId：微信openId
     */
    public $account_type;
    /**
     * @var string 账户ID
     */
    public $account_id;
    /**
     * @var Tag[] 标签集合
     */
    public $tags;

    public function __construct(string $accountType, string $accountId, array $tags)
    {
        $this->account_id = $accountId;
        $this->account_type = $accountType;
        foreach ($tags as $tag) {
            if (!($tag instanceof Tag)) {
                throw new BadTagParam('tags should be an array of Dezsidog\Youzanphp\Api\Params\Tag');
            }
        }
        $this->tags = $tags;
    }
}