<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


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
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, [
            'tid' => $tid
        ]);
        $response = $this->request($request);
        return $response;
    }

    /**
     * @param string $accountId 帐号ID
     * @param int $accountType 帐号类型（与帐户ID配合使用: 2=粉丝(原fansId),3:手机号,4:三方帐号(原open_user_id);6:微信open_id）
     * @param int $points 积分值
     * @param string $reason 积分变动原因
     * @param string $bizValue 用于幂等支持（幂等时效三个月, 超过三个月的相同值调用不保证幂等）
     * @param string $version
     * @return bool|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function pointIncrease(string $accountId, int $accountType, int $points, string $reason, string $bizValue = '', string $version = '3.1.0'): ?bool
    {
        $method = 'youzan.crm.customer.points.increase';
        $url = $this->buildUrl($method, $version);
        $params = $this->convert(compact('accountId', 'accountType', 'points', 'reason', 'bizValue'));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response ? $this->toBoolean($response['is_success']) : null;
    }

    /**
     * 获取分销员信息
     * @param int $fansType 粉丝类型（自有粉丝: fans_type = 1；当传mobile时，和fans_id一样传0）
     * @param int $fansId 粉丝id（mobile或fans_id选其一，另者置为0，当fans_id和mobile都传时，优先按mobile查询）
     * @param string $mobile 手机号（mobile或fans_id选其一，另者置为0，当fans_id和mobile都传时，优先按mobile查询）
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getSalesman(string $mobile, int $fansType = 0, int $fansId = 0, string $version = '3.0.1'): ?array
    {
        $method = 'youzan.salesman.account.get';
        $url = $this->buildUrl($method, $version);
        $params = $this->convert(compact('mobile', 'fansId', 'fansType'));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 根据交易号获取分销员手机号
     * @param string $tradeId 订单号
     * @param string $version
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPhoneByTrade(string $tradeId, string $version = '3.0.0'): ?string
    {
        $method = 'youzan.salesman.trades.account.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, [
            'order_no' => $tradeId
        ]);
        $response = $this->request($request);
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
        $url = $this->buildUrl($method, $version);
        $params = [
            'tags' => $tags
        ];
        if (is_string($id) && preg_match('/[a-zA-Z]/',$id)) {
            $params['weixin_openid'] = $id;
        } else {
            $params['fans_id'] = $id;
        }
        $request = $this->makeRequest($url, $params);
        return $this->request($request);
    }

    /**
     * 向客户添加tag
     * @param string $accountType 帐号类型。目前支持以下选项（只支持传一种）： FansID：自有粉丝ID， Mobile：手机号， YouZanAccount：有赞账号，OpenUserId：三方自身账号， WeiXinOpenId：微信openId
     * @param string $accountId 账户ID
     * @param array $tags 标签集合
     * @param string $version
     * @return bool|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function addCostumerTags(string $accountType, string $accountId, array $tags, string $version = '4.0.0'): ?bool
    {
        $method = 'youzan.scrm.tag.relation.add';
        $url = $this->buildUrl($method, $version);
        $params = $this->convert(compact('accountType', 'accountId', 'tags'));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return is_bool($response) ? $response : null;
    }

    /**
     * 根据手机号码获取openId
     * @param string $mobile
     * @param string $countryCode
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOpenIdByPhone(string $mobile, string $countryCode = '86', string $version = '3.0.0'): ?array
    {
        $method = 'youzan.user.weixin.openid.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, [
            'mobile' => $mobile,
            'country_code' => $countryCode
        ]);
        $response = $this->request($request);
        return $response;
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
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response;
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
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 获取在销售的商品
     * @param int $pageSize 每页条数，最大300个，不传或为0时默认设置为40
     * @param int $pageNo 页码，不传或为0时默认设置为1
     * @param string $q 搜索字段。搜索商品名
     * @param int $tagId 商品分组ID,使用youzan.itemcategories.tags.get 查询商品分组接口获取id进行筛选
     * @param Carbon|null $updateTimeStart 更新时间起始，Unix时间戳请求 时间单位:ms
     * @param Carbon|null $updateTimeEnd 更新时间起始，Unix时间戳请求 时间单位:ms
     * @param string $orderBy 排序方式。格式为column:asc/desc，目前排序字段：1—创建时间：created_time，2—更新时间：update_time，3—价格：price，4—销量：sold_num
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getOnSaleItems(
        int $pageNo = 1,
        int $pageSize = 40,
        string $q = '',
        int $tagId = 0,
        ?Carbon $updateTimeStart = null,
        ?Carbon $updateTimeEnd = null,
        string $orderBy = 'created_time:desc',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.items.onsale.get';
        $url = $this->buildUrl($method, $version);
        $updateTimeStart = ($updateTimeStart->timestamp * 1000) + intval(substr(strval($updateTimeStart->micro), 0, 3));
        $updateTimeEnd = ($updateTimeEnd->timestamp * 1000) + intval(substr(strval($updateTimeEnd->micro), 0, 3));
        $params = $this->convert(compact(
            'pageNo',
            'pageSize',
            'q',
            'tagId',
            'updateTimeStart',
            'updateTimeEnd',
            'orderBy'));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 获取仓库中的商品
     * @param int $pageSize 每页条数，最大支持300
     * @param int $pageNo 页码
     * @param string $banner 分类字段。可选值：for_shelved（已下架的）/ sold_out（已售罄的）
     * @param string $q 搜索字段。搜索商品的title
     * @param int $tagId 商品标签的ID
     * @param Carbon|null $updateTimeStart 更新时间起始，时间单位ms
     * @param Carbon|null $updateTimeEnd 更新时间止，时间单位ms
     * @param string $orderBy 排序方式。格式为column:asc/desc，目前排序字段：1.创建时间：created_time，2.更新时间：update_time，3.价格：price，4.销量：sold_num
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getInventoryItems(
        int $pageNo = 1,
        int $pageSize = 40,
        string $banner = '',
        string $q = '',
        int $tagId = 0,
        ?Carbon $updateTimeStart = null,
        ?Carbon $updateTimeEnd = null,
        string $orderBy = 'created_time:desc',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.items.inventory.get';
        $url = $this->buildUrl($method, $version);
        $updateTimeStart = ($updateTimeStart->timestamp * 1000) + intval(substr(strval($updateTimeStart->micro), 0, 3));
        $updateTimeEnd = ($updateTimeEnd->timestamp * 1000) + intval(substr(strval($updateTimeEnd->micro), 0, 3));
        $params = $this->convert(compact(
            'pageNo',
            'pageSize',
            'banner',
            'q',
            'tagId',
            'updateTimeStart',
            'updateTimeEnd',
            'orderBy'
        ));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 获取所有商品，包括上架的和仓库中的
     * @param int $pageSize 每页数量，要求小于200，要求page_size与page_no乘积小于4000
     * @param int $pageNo 页，要求小于20，要求page_size与page_no乘积小于4000
     * @param string $itemIds 作为查询条件的商品ID列表，以逗号分隔，如:457692126,457455556
     * @param int $showSoldOut 是否在售: 0—在售 1—售罄或部分售罄 2—全部
     * @param string $q 搜索字段。支持搜索：商品名
     * @param string $tagIds 作为查询的分组ID列表，以逗号分隔，如:106590390,106590393
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getProducts(
        int $pageNo = 1,
        int $pageSize = 40,
        string $itemIds = '',
        int $showSoldOut = 2,
        string $q = '',
        string $tagIds = '',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.item.search';
        $url = $this->buildUrl($method, $version);
        $params = $this->convert(compact(
            'pageNo',
            'pageSize',
            'itemIds',
            'showSoldOut',
            'q',
            'tagIds'
        ));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
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
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 向用户发送赠品
     * @param int $activityId 赠品活动ID
     * @param int $fansId 微信粉丝ID，fans_id和buyer_id至少要传一个
     * @param int $buyerId 有赞手机注册用户ID，fans_id和buyer_id至少要传一个
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function givePresent(int $activityId, int $fansId, int $buyerId = 0, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.ump.present.give';
        $url = $this->buildUrl($method, $version);
        $params = $this->convert(compact(
            'activityId',
            'fansId',
            'buyerId'
        ));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 获取进行中的赠品
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPresents(string $version = '3.0.0'): ?array {
        $method = 'youzan.ump.presents.ongoing.all';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response;
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
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, [
            'fields' => $fields
        ]);
        $response = $this->request($request);
        return $response;
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
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, [
            'id' => $id
        ]);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 发放优惠券/码
     * @param int $couponGroupId 优惠券/码活动ID
     * @param string $identify
     * @param string $type mobile，weixin_openid，fans_id，open_user_id
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function takeCoupon(int $couponGroupId, string $identify, string $type, $version='3.0.0'): ?array
    {
        $method = 'youzan.ump.coupon.take';
        $url = $this->buildUrl($method, $version);
        $params = [
            'coupon_group_id' => $couponGroupId,
            $type => $identify
        ];
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * （分页查询）查询优惠券（码）活动列表
     * @param string $groupType
     * @param string $status
     * @param int $pageNo
     * @param int $pageSize
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getCouponList(string $groupType, string $status, int $pageNo = 1, int $pageSize = 1000, string $version = '3.0.0'): ?array
    {
        $method = 'youzan.ump.coupon.search';
        $url = $this->buildUrl($method, $version);
        $params = $this->convert(compact(
            'groupType',
            'status',
            'pageNo',
            'pageSize'
        ));
        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response;
    }

    /**
     * 获取分销员列表
     * @param int $pageNo
     * @param int $pageSize
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSalesmanList($pageNo = 1, $pageSize = 100, $version = '3.0.0'): ?array
    {
        $method = 'youzan.salesman.accounts.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, [
            'page_no' => $pageNo,
            'page_size' => $pageSize
        ]);
        $response = $this->request($request);
        return $response;
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
        $url = $this->buildUrl($method, $version);
        if ($alias) {
            $params = [
                'alias' => $identification
            ];
        } else {
            $params = [
                'item_id' => $identification
            ];
        }
        $request = $this->makeRequest($url, $params);
        return $this->request($request);
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

        $url = $this->buildUrl($method, $version);

        if (is_string($id) && preg_match('/[a-zA-Z]/',$id)) {
            $params['weixin_openid'] = $id;
        } else {
            $params['fans_id'] = $id;
        }

        $request = $this->makeRequest($url, $params);
        $response = $this->request($request);
        return $response ? $response['user'] : null;
    }

    protected function buildUrl(string $method, string $version, array $query = []) {
        $query = array_merge(['access_token' => $this->accessToken], $query);
        return sprintf(self::URL.'%s/%s?%s', $method, $version, http_build_query($query));
    }

    protected function makeRequest(string $url, ?array $params = null, string $method = 'POST'): Request
    {
        if (is_array($params)) {
            $params = \GuzzleHttp\json_encode($params);
        }
        return new Request($method, $url, [], $params);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function convert(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $convert = new Convert($key);
            $result[$convert->toSnake()] = $value;
        }

        return $result;
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