<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


use Dezsidog\Youzanphp\Exceptions\BadParam;

class GivePresent extends BaseParams
{
    /**
     * @var int 赠品活动ID
     */
    public $activity_id;
    /**
     * @var int 微信粉丝ID，fans_id和buyer_id至少要传一个
     */
    public $fans_id;
    /**
     * @var int 有赞手机注册用户ID，fans_id和buyer_id至少要传一个
     */
    public $buyer_id;

    public function __construct(int $activityId, int $fansId = 0, int $buyerId = 0)
    {
        $this->activity_id = $activityId;
        $this->fans_id = $fansId;
        $this->buyer_id = $buyerId;
        if (!$this->buyer_id && $this->fans_id) {
            throw new BadParam('fansId and buyerId at least one');
        }
    }

    public function __toString(): string
    {
        $data = [
            'activity_id' => $this->activity_id
        ];
        $this->fans_id ? $data['fans_id'] = $this->fans_id : null;
        $this->buyer_id ? $data['buyer_id'] = $this->buyer_id : null;

        return \GuzzleHttp\json_encode($data);
    }
}