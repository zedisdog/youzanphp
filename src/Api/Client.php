<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


use Dezsidog\Youzanphp\Api\Models\OpenId;
use Dezsidog\Youzanphp\Api\Models\SalesmanAccount;
use Dezsidog\Youzanphp\Api\Models\Shop;
use Dezsidog\Youzanphp\Api\Models\Simple;
use Dezsidog\Youzanphp\Api\Models\Trade;
use Dezsidog\Youzanphp\Api\Params\AddTag;
use Dezsidog\Youzanphp\Api\Params\IncreasePoint;
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
     * @param string $tid
     * @param string $version
     * @return Trade|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function trade(string $tid, string $version = '4.0.0'): ?Trade
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
     */
    public function increasePoint(string $accountId, int $accountType, int $points, string $reason, string $biz_value = '', string $version = '3.1.0'): ?Simple
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
     */
    public function getShopInfo($version = '3.0.0')
    {
        $method = 'youzan.shop.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url);
        $response = $this->request($request);
        return $response ? new Shop($response) : null;
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