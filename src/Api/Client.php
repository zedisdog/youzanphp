<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


use Dezsidog\Youzanphp\Api\Models\Trade;
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
        return new Trade($response);
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