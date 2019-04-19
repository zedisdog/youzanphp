<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Client;


use Dezsidog\Youzanphp\Api\Models\Trade;
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

    public function trade(string $tid): ?Trade
    {

    }

    protected function makeRequest(string $url, ?Params $params = null, string $method = 'POST'): Request
    {
        return new Request($method, $url, [], $params);
    }
}