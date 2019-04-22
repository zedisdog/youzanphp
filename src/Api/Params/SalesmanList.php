<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


class SalesmanList extends BaseParams
{
    /**
     * @var int 页码
     */
    public $page_no;
    /**
     * @var int 每页记录数，最大不超过100，建议使用默认值20
     */
    public $page_size;

    public function __construct(int $pageNo, int $pageSize)
    {
        $this->page_no = $pageNo;
        $this->page_size = $pageSize;
    }
}