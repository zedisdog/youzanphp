<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Params;


use Carbon\Carbon;

class ItemsOnsale extends BaseParams
{
    /**
     * @var int 商品分组ID,使用youzan.itemcategories.tags.get 查询商品分组接口获取id进行筛选
     */
    public $tag_id;
    /**
     * @var string 搜索字段。搜索商品名
     */
    public $q;
    /**
     * @var int 每页条数，最大300个，不传或为0时默认设置为40
     */
    public $page_size;
    /**
     * @var int 页码，不传或为0时默认设置为1
     */
    public $page_no;
    /**
     * @var string 排序方式。格式为column:asc/desc，目前排序字段：1—创建时间：created_time，2—更新时间：update_time，3—价格：price，4—销量：sold_num
     */
    public $order_by;
    /**
     * @var float 更新时间起始，Unix时间戳请求 时间单位:ms
     */
    public $update_time_start;
    /**
     * @var float 更新时间止，Unix时间戳请求 时间单位:ms
     */
    public $update_time_end;

    public function __construct(
        int $pageSize = 40,
        int $pageNo = 1,
        string $q = '',
        int $tagId = 0,
        ?Carbon $updateTimeStart = null,
        ?Carbon $updateTimeEnd = null,
        string $orderBy = 'created_time:desc'
    )
    {
        $this->update_time_start = $updateTimeStart ? $updateTimeStart->valueOf() : 0;
        $this->update_time_end = $updateTimeEnd ? $updateTimeEnd->valueOf() : 0;
        $this->tag_id = $tagId;
        $this->q = $q;
        $this->page_size = $pageSize;
        $this->page_no = $pageNo;
        $this->order_by = $orderBy;
    }

    public function __toString(): string
    {
        $data = [];
        $this->update_time_start ? $data['update_time_start'] = $this->update_time_start : null;
        $this->update_time_end ? $data['update_time_end'] = $this->update_time_end : null;
        $this->tag_id ? $data['tag_id'] = $this->tag_id : null;
        $this->q ? $data['q'] = $this->q : null;
        $data['page_size'] = $this->page_size;
        $data['page_no'] = $this->page_no;
        $data['order_by'] = $this->order_by;
        return \GuzzleHttp\json_encode($data);
    }
}