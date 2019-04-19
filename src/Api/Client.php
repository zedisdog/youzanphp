<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


use Dezsidog\Youzanphp\Api\Models\SalesmanAccount;
use Dezsidog\Youzanphp\Api\Models\Simple;
use Dezsidog\Youzanphp\Api\Models\Trade;
use Dezsidog\Youzanphp\Api\Params\IncreasePointParams;
use Dezsidog\Youzanphp\Api\Params\SalesmanAccountParams;
use Dezsidog\Youzanphp\Api\Params\TradeParams;
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
        $request = $this->makeRequest($url, new TradeParams($tid));
        $response = $this->request($request);
        return $response ? new Trade($response) : null;
    }

    /**
     * @param string $accountId 帐号ID
     * @param int $accountType 帐号类型（与帐户ID配合使用: 2=粉丝(原fansId),3:手机号,4:三方帐号(原open_user_id);6:微信open_id）
     * @param int $points 积分值
     * @param string $reason 积分变动原因
     * @param string $biz_value 用于幂等支持（幂等时效三个月, 超过三个月的相同值调用不保证幂等）
     * @return Simple|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function increasePoint(string $accountId, int $accountType, int $points, string $reason, string $biz_value = '', string $version = '3.1.0'): ?Simple
    {
        $method = 'youzan.crm.customer.points.increase';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new IncreasePointParams($accountId, $accountType, $points, $reason, $biz_value));
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
    public function salesmanAccount(int $fansType, int $fansId, string $mobile, string $version = '3.0.1')
    {
        $method = 'youzan.salesman.account.get';
        $url = $this->buildUrl($method, $version);
        $request = $this->makeRequest($url, new SalesmanAccountParams($fansType, $fansId, $mobile));
        $response = $this->request($request);
        return $response ? new SalesmanAccount($response) : null;
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