<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class Dist extends BaseModel
{
    /**
     * @var string 包裹id
     */
    public $distId;
    /**
     * @var ExpressInfo 包裹详情
     */
    public $expressInfo;

    protected function parse()
    {
        $this->distId = $this->raw['dist_id'];
        $this->expressInfo = new ExpressInfo($this->raw['express_info']);
    }
}