<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


class CouponList extends BaseParams
{
    /**
     * @var string 活动状态。FUTURE：未开始 ；END：已结束；ON：进行中 （默认查所有状态）
     */
    public $status;
    /**
     * @var int 每页数量
     */
    public $page_size;
    /**
     * @var int 第几页
     */
    public $page_no;
    /**
     * @var string 活动类型。PROMOCARD：优惠券；PROMOCODE：优惠码
     */
    public $group_type;

    public function __construct(string $groupType, string $status, int $pageNo = 1, int $pageSize = 1000)
    {
        $this->group_type = $groupType;
        $this->status = $status;
        $this->page_no = $pageNo;
        $this->page_size = $pageSize;
    }
}