<?php
/**
 * Created by zed.
 */

class DecrypterTest extends \PHPUnit\Framework\TestCase
{
    public function testDecrypt()
    {
        $data = '{"module_code":"001","message":"7iEu%2Blj0t8v1%2BybCeanMCtCbN3Wx5LawFPMaUITEG7I0kmhQ9TcyAAvNmt7oxm5Ei5ernDzx3Wr%2B0Fi6bTAVfR24WDoRWdQdS5X1tJn4cfnZItnN7m1rQmf3SMxgeoDfkQPfYB1L9ZCCprGQnHgyb%2B%2Bk7VWMLvWVNz%2FaxMb3CT9rJ3BYTHWMd4DjmGGxMpeQY6RI6sfiK2SQHBrvHvHnZ6YfBo0eaNzPeWPMkcLvs8xfqyZxzBKGCzjqcMjic6FtRrVvLI3RmTKtAJTqTaV2lToxTEptxdNuOHGjmxQq5Q56wON5l%2B%2Fvb5U8CAuS1nxfWoLBRbiG979Gcy6Lpd%2FNDg%3D%3D"}';
        $secret = 'dfee7097a9b77c394c2439c838e';
        $d = new \Dezsidog\Youzanphp\Sec\Decrypter($secret);
        $result = $d->decrypt(json_decode($data, true)['message']);
        $this->assertIsArray($result);
    }
}