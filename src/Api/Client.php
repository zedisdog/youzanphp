<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


use Carbon\Carbon;
use Dezsidog\Youzanphp\Api\Models\Category;
use Dezsidog\Youzanphp\Api\Models\Coupon;
use Dezsidog\Youzanphp\Api\Models\CouponDetail;
use Dezsidog\Youzanphp\Api\Models\GivePresent;
use Dezsidog\Youzanphp\Api\Models\ListedProduct;
use Dezsidog\Youzanphp\Api\Models\OpenId;
use Dezsidog\Youzanphp\Api\Models\Present;
use Dezsidog\Youzanphp\Api\Models\SalesmanAccount;
use Dezsidog\Youzanphp\Api\Models\Shop;
use Dezsidog\Youzanphp\Api\Models\ShopBasic;
use Dezsidog\Youzanphp\Api\Models\Simple;
use Dezsidog\Youzanphp\Api\Models\TakeCoupon;
use Dezsidog\Youzanphp\Api\Models\Trade;
use Dezsidog\Youzanphp\Api\Params\AddTag;
use Dezsidog\Youzanphp\Api\Params\CouponList;
use Dezsidog\Youzanphp\Api\Params\CouponsUnfinished;
use Dezsidog\Youzanphp\Api\Params\IncreasePoint;
use Dezsidog\Youzanphp\Api\Params\Items;
use Dezsidog\Youzanphp\Api\Params\SalesmanByTradeId;
use Dezsidog\Youzanphp\BaseClient;
use Dezsidog\Youzanphp\Contract\Params;
use GuzzleHttp\Psr7\Request;

class Client extends BaseClient
{
    const URL = 'https://open.youzanyun.com/api/';
    protected $accessToken;

    public function __construct(string $accessToken)
    {
        parent::__construct();
        $this->accessToken = $accessToken;
    }

    /**
     * 获取交易信息
     * @param string $tid
     * @param string $version
     * @return Trade|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getTrade(string $tid, string $version = '4.0.0'): ?Trade
    {
        $method = 'youzan.trade.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new \Dezsidog\Youzanphp\Api\Params\Trade($tid));
        $response = $this->request($request);
        return $response ? new Trade($response) : null;
    }

    /**
     * @param string $accountId 帐号ID
     * @param int $accountType 帐号类型（与帐户ID配合使用: 2=粉丝(原fansId),3:手机号,4:三方帐号(原open_user_id);6:微信open_id）
     * @param int $points 积分值
     * @param string $reason 积分变动原因
     * @param string $biz_value 用于幂等支持（幂等时效三个月, 超过三个月的相同值调用不保证幂等）
     * @param string $version
     * @return Simple|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function pointIncrease(string $accountId, int $accountType, int $points, string $reason, string $biz_value = '', string $version = '3.1.0'): ?Simple
    {
        $method = 'youzan.crm.customer.points.increase';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new IncreasePoint($accountId, $accountType, $points, $reason, $biz_value));
        $response = $this->request($request);
        return $response ? new Simple($response) : null;
    }

    /**
     * @param int $fansType
     * @param int $fansId
     * @param string $mobile
     * @param string $version
     * @return SalesmanAccount|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function salesmanAccount(int $fansType, int $fansId, string $mobile, string $version = '3.0.1'): SalesmanAccount
    {
        $method = 'youzan.salesman.account.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new \Dezsidog\Youzanphp\Api\Params\SalesmanAccount($fansType, $fansId, $mobile));
        $response = $this->request($request);
        return $response ? new SalesmanAccount($response) : null;
    }

    /**
     * 根据交易号获取分销员手机号
     * @param string $tradeId
     * @param string $version
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPhoneByTrade(string $tradeId, string $version = '3.0.0'): ?string
    {
        $method = 'youzan.salesman.trades.account.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new SalesmanByTradeId($tradeId));
        $response = $this->request($request);
        return $response ? $response['mobile'] : null;
    }

    /**
     * 向用户添加tag
     * @param string $accountType
     * @param string $accountId
     * @param array $tags
     * @param string $version
     * @return bool|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addTags(string $accountType, string $accountId, array $tags, string $version = '4.0.0'): ?bool
    {
        $method = 'youzan.scrm.tag.relation.add';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new AddTag($accountType, $accountId, $tags));
        $response = $this->request($request);
        return is_bool($response) ? $response : null;
    }

    /**
     * 根据手机号码获取openId
     * @param string $phone
     * @param string $countryCode
     * @param string $version
     * @return OpenId|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getOpenIdByPhone(string $phone, string $countryCode = '86', string $version = '3.0.0'): ?OpenId
    {
        $method = 'youzan.user.weixin.openid.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new \Dezsidog\Youzanphp\Api\Params\OpenId($phone, $countryCode));
        $response = $this->request($request);
        return $response ? new OpenId($response) : null;
    }

    /**
     * 获取店铺信息
     * @param string $version
     * @return Shop|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getShopInfo($version = '3.0.0')
    {
        $method = 'youzan.shop.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response ? new Shop($response) : null;
    }

    /**
     * 获取商品类目列表
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getItemCategories(string $version = '3.0.0'): ?array
    {
        $method = 'youzan.itemcategories.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        if ($response) {
            $categories = [];
            foreach ($response['categories'] as $item) {
                array_push($categories, new Category($item));
            }
            return [$categories, $response['count']];
        } else {
            return null;
        }
    }

    /**
     * 获取在销售的商品
     * @param int $pageSize
     * @param int $pageNo
     * @param string $q
     * @param int $tagId
     * @param Carbon|null $updateTimeStart
     * @param Carbon|null $updateTimeEnd
     * @param string $orderBy
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getOnSaleItems(
        int $pageSize = 40,
        int $pageNo = 1,
        string $q = '',
        int $tagId = 0,
        ?Carbon $updateTimeStart = null,
        ?Carbon $updateTimeEnd = null,
        string $orderBy = 'created_time:desc',
        string $version = '3.0.0'
    ): array {
        $method = 'youzan.items.onsale.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new Items(
            $pageSize,
            $pageNo,
            '',
            '',
            null,
            $q,
            $tagId,
            '',
            $updateTimeStart,
            $updateTimeEnd,
            $orderBy
        ));
        $response = $this->request($request);
        if ($response) {
            $products = [];
            foreach ($response['items'] as $item) {
                array_push($products, new ListedProduct($item));
            }
            return [$products, $response['count']];
        } else {
            return null;
        }
    }

    /**
     * 获取仓库中的商品
     * @param int $pageSize
     * @param int $pageNo
     * @param string $banner
     * @param string $q
     * @param int $tagId
     * @param Carbon|null $updateTimeStart
     * @param Carbon|null $updateTimeEnd
     * @param string $orderBy
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getInventoryItems(
        int $pageSize = 40,
        int $pageNo = 1,
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
        $request = $this->makeRequest($url, new Items(
            $pageSize,
            $pageNo,
            '',
            $banner,
            null,
            $q,
            $tagId,
            '',
            $updateTimeStart,
            $updateTimeEnd,
            $orderBy
        ));
        $response = $this->request($request);
        if ($response) {
            $products = [];
            foreach ($response['items'] as $item) {
                array_push($products, new ListedProduct($item));
            }
            return [$products, $response['count']];
        } else {
            return null;
        }
    }

    /**
     * 获取所有商品，包括上架的和仓库中的
     * @param int $pageSize
     * @param int $pageNo
     * @param string $itemIds
     * @param int $showSoldOut
     * @param string $q
     * @param string $tagIds
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getProducts(
        int $pageSize = 40,
        int $pageNo = 1,
        string $itemIds = '',
        int $showSoldOut = 2,
        string $q = '',
        string $tagIds = '',
        string $version = '3.0.0'
    ): ?array {
        $method = 'youzan.item.search';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new Items(
            $pageSize,
            $pageNo,
            $itemIds,
            '',
            $showSoldOut,
            $q,
            0,
            $tagIds
        ));
        $response = $this->request($request);
        if ($response) {
            $products = [];
            foreach ($response['items'] as $item) {
                array_push($products, new ListedProduct($item));
            }
            return [$products, $response['count']];
        } else {
            return null;
        }
    }

    /**
     * 获取店铺基础信息
     * @param string $version
     * @return ShopBasic|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getShopBaseInfo(string $version = '3.0.0'): ?ShopBasic
    {
        $method = 'youzan.shop.basic.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response ? new ShopBasic($response) : null;
    }

    /**
     * 向用户发送赠品
     * @param int $activityId
     * @param int $fansId
     * @param int $buyerId
     * @param string $version
     * @return GivePresent|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function givePresent(int $activityId, int $fansId, int $buyerId = 0, string $version = '3.0.0'): ?GivePresent
    {
        $method = 'youzan.ump.present.give';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new \Dezsidog\Youzanphp\Api\Params\GivePresent($activityId, $fansId, $buyerId));
        $response = $this->request($request);
        return $response ? new GivePresent($response) : null;
    }

    /**
     * 获取进行中的赠品
     * @param string $version
     * @return Present[]|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getPresents(string $version = '3.0.0'): ?array {
        $method = 'youzan.ump.presents.ongoing.all';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        if ($response) {
            $result = [];
            foreach ($response as $item) {
                array_push($result, new Present($item));
            }
            return $result;
        } else {
            return null;
        }
    }

    /**
     * 获取未结束的优惠活动
     * @param string $fields
     * @param string $version
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getUnfinishedCoupons(string $fields = '', string $version = '3.0.0'): ?array {
        $method = 'youzan.ump.coupons.unfinished.search';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new CouponsUnfinished($fields));
        $response = $this->request($request);
        if ($response) {
            $result = [];
            foreach ($response as $item) {
                array_push($result, new Coupon($item));
            }
            return $result;
        } else {
            return null;
        }
    }

    /**
     * 获取优惠券详情
     * @param int $id
     * @param string $version
     * @return CouponDetail|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function getCoupon(int $id, string $version='3.0.0'): ?CouponDetail
    {
        $method = 'youzan.ump.coupon.detail.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new \Dezsidog\Youzanphp\Api\Params\CouponDetail($id));
        $response = $this->request($request);
        return $response ? new CouponDetail($response) : null;
    }

    /**
     * 发放优惠券/码
     * @param int $couponGroupId
     * @param string $identify
     * @param string $type
     * @param string $version
     * @return TakeCoupon|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function takeCoupon(int $couponGroupId, string $identify, string $type, $version='3.0.0'): ?TakeCoupon
    {
        $method = 'youzan.ump.coupon.take';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new \Dezsidog\Youzanphp\Api\Params\TakeCoupon($couponGroupId, $identify, $type));
        $response = $this->request($request);
        return $response ? new TakeCoupon($response) : null;
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
        $request = $this->makeRequest($url, new CouponList($groupType, $status, $pageNo, $pageSize));
        $response = $this->request($request);
        if ($response) {
            $result = [];
            foreach ($response['groups'] as $item) {
                array_push($result, new CouponDetail($item));
            }
            return [$result, $response['total']];
        } else {
            return null;
        }
    }

    protected function buildUrl(string $method, string $version, array $query = []) {
        $query = array_merge(['access_token' => $this->accessToken], $query);
        return sprintf(self::URL.'%s/%s?%s', $method, $version, http_build_query($query));
    }

    protected function makeRequest(string $url, ?Params $params = null, string $method = 'POST'): Request
    {
        return new Request($method, $url, [], $params);
    }
}