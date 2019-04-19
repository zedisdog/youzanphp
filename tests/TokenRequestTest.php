<?php
/**
 * Created by zed.
 */

use Dezsidog\Youzanphp\Oauth2\TokenParams;
use PHPUnit\Framework\TestCase;

class TokenRequestTest extends TestCase
{
    public function testToString()
    {
        $request = new TokenParams('test', 'test', 'test', 'test');
        $this->assertEquals(
            '{"client_id":"test","client_secret":"test","code":"test","redirect_uri":"test","authorize_type":"authorization_code"}',
            strval($request)
        );
    }
}