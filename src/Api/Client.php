<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api;


use Carbon\Carbon;
use Dezsidog\Youzanphp\BaseClient;
use GuzzleHttp\Psr7\Request;
use Jawira\CaseConverter\Convert;
use Psr\Log\LoggerInterface;

class Client extends BaseClient
{
    const URL = 'https://open.youzanyun.com/api/';
    protected $accessToken;

    public function __construct(string $accessToken = '', ?LoggerInterface $logger = null)
    {
        parent::__construct($logger);
        $this->accessToken = $accessToken;
    }

    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * 获取交易信息
     * @param string $tid 订单id
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTrade(string $tid, string $version = '4.0.0'): ?array
    {
        $method = 'youzan.trade.get';
        $params = compact('tid');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * @param string $account_id 帐号ID
     * @param int $account_type 帐号类型（与帐户ID配合使用: 2=粉丝(原fansId),3:手机号,4:三方帐号(原open_user_id);6:微信open_id）
     * @param int $points 积分值
     * @param string $reason 积分变动原因
     * @param string $biz_value 用于幂等支持（幂等时效三个月, 超过三个月的相同值调用不保证幂等）
     * @param string $version
     * @return bool|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function pointIncrease(string $account_id, int $account_type, int $points, string $reason, string $biz_value = '', string $version = '3.1.0'): ?bool
    {
        $method = 'youzan.crm.customer.points.increase';
        $params = compact('account_id', 'account_type', 'points', 'reason', 'biz_value');
        $response = $this->getResponse($method, $version, $params);
        return $response ? $this->toBoolean($response['is_success']) : null;
    }

    /**
     * 获取分销员信息
     * @param string|int $identification
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSalesman($identification, string $version = '3.0.1'): ?array
    {
        $method = 'youzan.salesman.account.get';
        if ($this->isMobile($identification)) {
            $params['mobile'] = $identification;
            $params['fans_type'] = 0;
            $params['fans_id'] = 0;
        } else {
            $params['fans_id'] = $identification;
            $params['mobile'] = 0;
            $params['fans_type'] = 1;
        }
        $response = $this->getResponse($method, $version, $params);
        return isset($response['user']) ? $response['user'] : $response;
    }

    protected function isMobile(string $str): bool
    {
        return is_string($str) && preg_match('/^1[3-9]\d{9}$/', $str);
    }

    /**
     * 添加分销员
     * @param string $identification 手机号或者fans_id
     * @param int $fans_type
     * @param string $from_mobile
     * @param int $level
     * @param int $group_id
     * @param string $version
     * @return bool|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addSalesmanAccount(
        $identification,
        int $fans_type = 0,
        string $from_mobile = '',
        int $level = 0,
        int $group_id = 0,
        string $version = '3.0.1'
    ): bool {
        $method = 'youzan.salesman.account.add';
        $params = compact('fans_type', 'from_mobile', 'level', 'group_id');
        foreach ($params as $key => $value) {
            if (!$value && $key != 'fans_type') {
                unset($params[$key]);
            }
        }
        if ($this->isMobile($identification)) {
            $params['mobile'] = $identification;
            $params['fans_id'] = 0;
        } else {
            $params['fans_id'] = $identification;
            $params['mobile'] = '0';
        }
        $response = $this->getResponse($method, $version, $params);
        return $response?$response['isSuccess']:false;
    }

    /**
     * 根据交易号获取分销员手机号
     * @param string $order_no 订单号
     * @param string $version
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPhoneByTrade(string $order_no, string $version = '3.0.0'): ?string
    {
        $method = 'youzan.salesman.trades.account.get';
        $params = compact('order_no');
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['mobile'] : null;
    }

    /**
     * 向用户添加tag
     * @param int $id
     * @param string $tags
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addTags(int $id, string $tags, $version = '3.0.0'): ?array
    {
        $method = 'youzan.users.weixin.follower.tags.add';
        $params = [
            'tags' => $tags
        ];
        if (is_string($id) && preg_match('/[a-zA-Z]/',$id)) {
            $params['weixin_openid'] = $id;
        } else {
            $params['fans_id'] = $id;
        }
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['user'] : null;
    }

    /**
     * 向客户添加tag
     * @param string $account_type 帐号类型。目前支持以下选项（只支持传一种）： FansID：自有粉丝ID， Mobile：手机号， YouZanAccount：有赞账号，OpenUserId：三方自身账号， WeiXinOpenId：微信openId
     * @param string $account_id 账户ID
     * @param array $tags 标签集合
     * @param string $version
     * @return bool|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function addCostumerTags(string $account_type, string $account_id, array $tags, string $version = '4.0.0'): ?bool
    {
        $method = 'youzan.scrm.tag.relation.add';
        $params = compact('account_type', 'account_id', 'tags');
        $response = $this->getResponse($method, $version, $params);
        return is_bool($response) ? $response : null;
    }
    /**
     * 根据手机号码获取openId
     * @param string $mobile
     * @param string $country_code
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOpenIdByPhone(string $mobile, string $country_code = '+86', string $version = '3.0.0'): ?array
    {
        $method = 'youzan.user.weixin.openid.get';
        $params = compact('mobile', 'country_code');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取店铺信息
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getShopInfo(string $version = '3.0.0'): ?array
    {
        $method = 'youzan.shop.get';
        return $this->getResponse($method, $version);
    }

    /**
     * 获取商品类目列表
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getItemCategories(string $version = '3.0.0'): ?array
    {
        $method = 'youzan.itemcategories.get';
        return $this->getResponse($method, $version);
    }

    /**
     * 获取在销售的商品
     * @param int $page_size 每页条数，最大300个，不传或为0时默认设置为40
     * @param int $page_no 页码，不传或为0时默认设置为1
     * @param string $q 搜索字段。搜索商品名
     * @param int $tag_id 商品分组ID,使用youzan.itemcategories.tags.get 查询商品分组接口获取id进行筛选
     * @param Carbon|null $update_time_start 更新时间起始，Unix时间戳请求 时间单位:ms
     * @param Carbon|null $update_time_end 更新时间起始，Unix时间戳请求 时间单位:ms
     * @param string $order_by 排序方式。格式为column:asc/desc，目前排序字段：1—创建时间：created_time，2—更新时间：update_time，3—价格：price，4—销量：sold_num
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getOnSaleItems(
        int $page_no = 1,
        int $page_size = 40,
        string $q = '',
        int $tag_id = 0,
        ?Carbon $update_time_start = null,
        ?Carbon $update_time_end = null,
        string $order_by = 'created_time:desc',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.items.onsale.get';
        $update_time_start = ($update_time_start->timestamp * 1000) + intval(substr(strval($update_time_start->micro), 0, 3));
        $update_time_end = ($update_time_end->timestamp * 1000) + intval(substr(strval($update_time_end->micro), 0, 3));
        $params = compact(
            'page_no',
            'page_size',
            'q',
            'tag_id',
            'update_time_start',
            'update_time_end',
            'order_by'
        );
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取仓库中的商品
     * @param int $page_size 每页条数，最大支持300
     * @param int $page_no 页码
     * @param string $banner 分类字段。可选值：for_shelved（已下架的）/ sold_out（已售罄的）
     * @param string $q 搜索字段。搜索商品的title
     * @param int $tag_id 商品标签的ID
     * @param Carbon|null $update_time_start 更新时间起始，时间单位ms
     * @param Carbon|null $update_time_end 更新时间止，时间单位ms
     * @param string $order_by 排序方式。格式为column:asc/desc，目前排序字段：1.创建时间：created_time，2.更新时间：update_time，3.价格：price，4.销量：sold_num
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getInventoryItems(
        int $page_no = 1,
        int $page_size = 40,
        string $banner = '',
        string $q = '',
        int $tag_id = 0,
        ?Carbon $update_time_start = null,
        ?Carbon $update_time_end = null,
        string $order_by = 'created_time:desc',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.items.inventory.get';
        $update_time_start = ($update_time_start->timestamp * 1000) + intval(substr(strval($update_time_start->micro), 0, 3));
        $update_time_end = ($update_time_end->timestamp * 1000) + intval(substr(strval($update_time_end->micro), 0, 3));
        $params = compact(
            'page_no',
            'page_size',
            'banner',
            'q',
            'tag_id',
            'update_time_start',
            'update_time_end',
            'order_by'
        );
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取所有商品，包括上架的和仓库中的
     * @param int $page_size 每页数量，要求小于200，要求page_size与page_no乘积小于4000
     * @param int $page_no 页，要求小于20，要求page_size与page_no乘积小于4000
     * @param string $item_ids 作为查询条件的商品ID列表，以逗号分隔，如:457692126,457455556
     * @param int $show_sold_out 是否在售: 0—在售 1—售罄或部分售罄 2—全部
     * @param string $q 搜索字段。支持搜索：商品名
     * @param string $tag_ids 作为查询的分组ID列表，以逗号分隔，如:106590390,106590393
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getProducts(
        int $page_no = 1,
        int $page_size = 40,
        string $item_ids = '',
        int $show_sold_out = 2,
        string $q = '',
        string $tag_ids = '',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.item.search';
        $params = compact(
            'page_no',
            'page_size',
            'item_ids',
            'show_sold_out',
            'q',
            'tag_ids'
        );
        return $this->getResponse($method, $version, $params);
    }

    /**
     * @param string $keyword
     * @param int $pageNo
     * @param int $pageSize
     * @param int|null $showSoldOut
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function itemSearch(
        string $keyword,
        int $pageNo = 1,
        int $pageSize = 100,
        int $showSoldOut = 2,
        $version = '3.0.0'
    ): ?array
    {
        return $this->getProducts($pageNo, $pageSize, '', $showSoldOut, $keyword, '', $version);
    }

    /**
     * @param array $itemIds
     * @param int $pageNo
     * @param int $pageSize
     * @param int|null $showSoldOut
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function itemListByItemIds(
        array $itemIds,
        int $pageNo = 1,
        int $pageSize = 100,
        int $showSoldOut = 2,
        $version = '3.0.0'
    ): ?array
    {
        return $this->getProducts($pageNo, $pageSize, implode(',', $itemIds), $showSoldOut, '', '', $version);
    }

    /**
     * 获取店铺基础信息
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getShopBaseInfo(string $version = '3.0.0'): ?array
    {
        $method = 'youzan.shop.basic.get';
        return $this->getResponse($method, $version);
    }

    /**
     * 向用户发送赠品
     * @param int $activity_id 赠品活动ID
     * @param int $fans_id 微信粉丝ID，fans_id和buyer_id至少要传一个
     * @param int $buyer_id 有赞手机注册用户ID，fans_id和buyer_id至少要传一个
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function givePresent(int $activity_id, int $fans_id, int $buyer_id = 0, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.ump.present.give';
        $params = compact(
            'activity_id',
            'fans_id',
            'buyer_id'
        );
//        if (!$params['fans_id']) {
//            unset($params['fans_id']);
//        }
//        if (!$params['buyer_id']) {
//            unset($params['buyer_id']);
//        }
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取进行中的赠品
     * @param array $fields
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPresents(array $fields = [], string $version = '3.0.0'): ?array {
        $method = 'youzan.ump.presents.ongoing.all';
        $params = [
            'fields' => implode(',', $fields)
        ];
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['presents'] : null;
    }

    /**
     * 获取未结束的优惠活动
     * @param string $fields 需要返回的优惠对象字段。可选值：优惠结构体中所有字段均可返回；多个字段用“,”分隔。如果为空则返回所有
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUnfinishedCoupons(string $fields = '', string $version = '3.0.0'): ?array {
        $method = 'youzan.ump.coupons.unfinished.search';
        $params = compact('fields');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取优惠券详情
     * @param int $id
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCoupon(int $id, string $version='3.0.0'): ?array
    {
        $method = 'youzan.ump.coupon.detail.get';
        $params = compact('id');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 发放优惠券/码
     * @param int $coupon_group_id 优惠券/码活动ID
     * @param string $identify
     * @param string $type mobile，weixin_openid，fans_id，open_user_id
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function takeCoupon(int $coupon_group_id, string $identify, string $type = 'fans_id', $version='3.0.0'): ?array
    {
        $method = 'youzan.ump.coupon.take';
        $params = [
            'coupon_group_id' => $coupon_group_id,
            $type => $identify
        ];
        return $this->getResponse($method, $version, $params);
    }

    /**
     * （分页查询）查询优惠券（码）活动列表
     * @param string $group_type
     * @param string $status
     * @param int $page_no
     * @param int $page_size
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getCouponList(string $group_type, string $status, int $page_no = 1, int $page_size = 1000, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.ump.coupon.search';
        $params = compact(
            'group_type',
            'status',
            'page_no',
            'page_size'
        );
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取分销员列表
     * @param int $page_no
     * @param int $page_size
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSalesmanList($page_no = 1, $page_size = 100, $version = '3.0.0'): ?array
    {
        $method = 'youzan.salesman.accounts.get';
        $params = compact('page_no', 'page_size');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取商品
     * @param integer|string $identification 标识
     * @param bool $alias 是否是别名
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function itemGet($identification, $alias = false, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.item.get';
        if ($alias) {
            $params = [
                'alias' => $identification
            ];
        } else {
            $params = [
                'item_id' => $identification
            ];
        }
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['item'] : null;
    }

    /**
     * 创建商品
     * @param array $params
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://doc.youzanyun.com/doc#/content/API/1-299/detail/api/0/521 参数说明
     */
    public function itemCreate(array $params, string $version = '3.0.1'): ?array
    {
        $method = 'youzan.item.create';
        $response = $this->getResponse($method, $version, $params);
        return $response['item'] ?? null;
    }

    /**
     * 更新商品
     * @param array $params
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://doc.youzanyun.com/doc#/content/API/1-299/detail/api/0/517 参数说明
     */
    public function itemUpdate(array $params, string $version = '3.0.1'): bool
    {
        $method = 'youzan.item.update';
        $response = $this->getResponse($method, $version, $params);
        return $response['is_success'] ?? false;
    }

    /**
     * 通过 open_id 或者 fans_id 获取用户信息
     * @param integer|string $id fans_id或者open_id
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFollower($id, string $version='3.0.0'): ?array
    {
        $method = 'youzan.users.weixin.follower.get';
        if (is_string($id) && preg_match('/[a-zA-Z]/',$id)) {
            $params['weixin_openid'] = $id;
        } else {
            $params['fans_id'] = $id;
        }
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['user'] : null;
    }

    /**
     * @param string $desc
     * @param string $oid
     * @param int $refund_fee
     * @param string $tid
     * @param string $version
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refund(string $desc, string $oid, int $refund_fee, string $tid, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.trade.refund.seller.active';
        $params = compact('refund_fee', 'oid', 'tid', 'desc');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 外部电子卡券创建核销码
     * @param string $tickets
     * @param string $order_no
     * @param int $single_num
     * @param string $version
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ticketCreate(string $tickets, string $order_no, int $single_num = 1, string $version = '1.0.0'): ?bool
    {
        $method = 'youzan.ebiz.external.ticket.create';
        $params = compact('tickets', 'order_no', 'single_num');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 外部电子卡券核销
     * @param array $params
     * @param string $version
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ticketVerify(array $params, $version = '1.0.0'): ?bool
    {
        if (empty($params['tickets']) || empty($params['orderNo'])) {
            throw new \LogicException('fields [tickets],[orderNo] are required');
        }
        $method = 'youzan.ebiz.external.ticket.verify';
        return $this->getResponse($method, $version, $params);
    }

    /**
     * @param string $push_ticket_url
     * @param string $get_ticket_url
     * @param string $provider
     * @param string $version
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ticketBind(string $push_ticket_url, string $get_ticket_url, string $provider = 'STANDARD', string $version = '1.0.0')
    {
        $method = 'youzan.ebiz.external.ticket.bind';
        $params = compact('push_ticket_url', 'get_ticket_url', 'provider');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 删除商品
     * @param $item_id
     * @param string $yz_open_id
     * @param string $version
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function itemDelete($item_id, string $yz_open_id = '', $version = '3.0.1'): bool
    {
        $method = 'youzan.item.delete';
        $params = [
            'item_id' => intval($item_id)
        ];
        if ($yz_open_id) {
            $params['yz_open_id'] = $yz_open_id;
        }
        $response = $this->getResponse($method, $version, $params);
        return $response['is_success'] ?? false;
    }

    /**
     * 上传图片
     * @param string $filename
     * @param string $version
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadImage(string $filename, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.materials.storage.platform.img.upload';
        $url = $this->buildUrl($method, $version);

        $request = new Request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen($filename, 'r')
                ]
            ]
        ]);

        $response = $this->request($request);
        return $response;
    }

    /**
     * 获取分组
     * @param bool $isSort
     * @param string $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTags(bool $isSort = false, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.itemcategories.tags.get';
        $param = [
            'is_sort' => $isSort
        ];
        $response = $this->getResponse($method, $version, $param);
        return $response ? $response['tags'] : null;
    }

    /**
     * 确认发货
     * @param array $param
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logisticsConfirm(array $param, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.logistics.online.confirm';
        $response = $this->getResponse($method, $version, $param);
        return $response ? $response : null;
    }

    /**
     * 物流信息更新
     * @param array $param
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logisticsUpdate(array $param, string $version = '3.0.1'): ?bool
    {
        $method = 'youzan.logistics.online.update';
        $trade_express_modify = [];
        foreach ($param as $key => $value) {
            if ($key != 'tid' && $key != 'yz_open_id') {
                $trade_express_modify[$key] = $value;
            }
        }
        $param['trade_express_modify'] = $trade_express_modify;
        $response = $this->getResponse($method, $version, $param);
        return $response ? $response['isSuccess'] : null;
    }

    /**
     * 获取物流公司列表
     * @param string $version
     * @return |null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function expressGet(string $version = '3.0.0'): ?array
    {
        $method = 'youzan.logistics.express.get';
        $response = $this->getResponse($method, $version);
        return $response ? $response['allExpress'] : null;
    }

    /**
     * 发货单查询
     * @param string $tid
     * @param array $options
     * @param string $kdt_id
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryDcByOrderNo(string $tid, array $options = [], string $kdt_id = '', string $version = '1.0.0'): ?array
    {
        $method = 'youzan.trade.dc.query.querybyorderno';
        $params = array_merge($options, [
            'include_operation_log' => true,
            'include_dist_order_and_detail' => true,
            'include_dist_order' => true,
            'include_item_delivery_status' => true,
            'tid' => $tid
        ]);
        if ($kdt_id) {
            $params['kdt_id'] = $kdt_id;
        }
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 获取运费模板
     * @param int $page_no
     * @param int $page_size
     * @param string $version
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logisticsTemplateGet(int $page_no, int $page_size = 20, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.logistics.template.search';
        $params = compact('page_no', 'page_size');
        return $this->getResponse($method, $version, $params);
    }

    /**
     * 计算运费
     * @param string $order_no
     * @param string $province_name
     * @param string $city_name
     * @param string $county_name
     * @param array $item_param_list
     * @param string $version
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logisticsFee(string $order_no, string $province_name, string $city_name, string $county_name, array $item_param_list, string $version = '3.0.0'): int
    {
        $method = 'youzan.logistics.fee.get';
        $params = compact('order_no', 'province_name', 'city_name', 'county_name', 'item_param_list');
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['totalPostage'] : 0;
    }

    /**
     * 获取分销员订单信息
     * @param array $params
     * @param string $version
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function salesmanTrades(array $params, $version = '3.0.1'): ?array
    {
        $method = 'youzan.salesman.trades.get';
        $response = $this->getResponse($method, $version, $params);
        return $response ? $response['list'] : null;
    }

    /**
     * @param string $method
     * @param string $version
     * @param array|null $params
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getResponse(string $method, string $version, ?array $params = null)
    {
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, $params);
        return $this->request($request);
    }

    /**
     * make request url with api method and version and some query if needed
     * @param string $method
     * @param string $version
     * @param array $query
     * @return string
     */
    public function buildUrl(string $method, string $version, array $query = []) {
        $query = array_merge(['access_token' => $this->accessToken], $query);
        return sprintf(self::URL.'%s/%s?%s', $method, $version, http_build_query($query));
    }

    /**
     * @param string $url
     * @param array|null $params
     * @param string $method
     * @return Request
     */
    protected function makeRequest(string $url, ?array $params = null, string $method = 'POST'): Request
    {
        if (is_array($params)) {
            $params = \GuzzleHttp\json_encode($params);
        }
        return new Request($method, $url, [], $params);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function toBoolean($value): bool
    {
        if(is_string($value)) {
            return $value == "true" ? true : false;
        } else {
            return boolval($value);
        }
    }
}