<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class DeliveryOrder extends BaseModel
{
    /**
     * @var int 改字段已弃用 包裹id已移至dists中的dist_id字段
     */
    public $pkId;
    /**
     * @var int 物流状态 0:待发货; 1:已发货
     */
    public $expressState;
    /**
     * @var int 物流类型 0:手动发货; 1:系统自动发货
     */
    public $expressType;
    /**
     * @var string[] 发货明细
     */
    public $oids;
    /**
     * @var Dist[] 包裹信息
     */
    public $dists;

    protected function parse() {
        $this->pkId = $this->raw['pk_id'];
        $this->expressState = $this->raw['express_state'];
        $this->expressType = $this->raw['express_type'];
        $this->oids = $this->raw['oids'];
        $this->dists = [];
        foreach ($this->raw['dists'] as $item) {
            array_push($this->dists, new Dist($item));
        }
    }
}