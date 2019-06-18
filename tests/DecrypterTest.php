<?php
/**
 * Created by zed.
 */

class DecrypterTest extends \PHPUnit\Framework\TestCase
{
    public function testDecrypt()
    {
        $data = '{"module_code":"001","message":"7iEu%2Blj0t8v1%2BybCeanMCtCbN3Wx5LawFPMaUITEG7I0kmhQ9TcyAAvNmt7oxm5Ei5ernDzx3Wr%2B0Fi6bTAVfR24WDoRWdQdS5X1tJn4cfnZItnN7m1rQmf3SMxgeoDfkQPfYB1L9ZCCprGQnHgyb%2B%2Bk7VWMLvWVNz%2FaxMb3CT9rJ3BYTHWMd4DjmGGxMpeQY6RI6sfiK2SQHBrvHvHnZ6YfBo0eaNzPeWPMkcLvs8xfqyZxzBKGCzjqcMjic6FtRrVvLI3RmTKtAJTqTaV2lToxTEptxdNuOHGjmxQq5Q56wON5l%2B%2Fvb5U8CAuS1nxfWoLBRbiG979Gcy6Lpd%2FNDg%3D%3D"}';
        $secret = '6564183e9f30a6927527b6a2ab1';
        $d = new \Dezsidog\Youzanphp\Sec\Decrypter($secret);
        $result = $d->decrypt('ekqu%2FqRxJOLNy1RFQkGIs0XY3U7HwHqY%2Btj2%2B2AHAJU0gyzu3c1F1dPfFbYynx3jVO9JuBw357hmJNPARTPUkYv7y2FmIWegqU1XWKx%2BgPARuxopLjZieVOyPrdVKNOru9MGe2%2FRAS8UoIJ5wmNUH13peXdeap80pNKLhVeTN6lKtuuMVxgjjk1oleApodVKjpBqdH%2FgSRugf04%2Fyw0%2Bi3RRryaqb040aDT07Y6TV4ajfUO0SYc6t2LGiWNjKRcHgihAYjhnnax%2Fjm28jWhxggicpfUI%2FvtDrQVndAKWrBuXX21IqC8TG6xfqU1bgyUqz%2B2Oug6e1QcOD0vxjyiF8g%3D%3D');
        var_dump($result);
        $this->assertIsArray($result);

        // ekqu%2FqRxJOLNy1RFQkGIs0XY3U7HwHqY%2Btj2%2B2AHAJU0gyzu3c1F1dPfFbYynx3jVO9JuBw357hmJNPARTPUkVDggAREfiv1Qcd7e0WC7qJuUGH7YjagbPnEYr9MWIPMrjY7z1gewJiXECzbCLZOuBHBOo70DzkPjj5FyQ7aD3Zc42bXNev3%2FJCcke3S8qKhsvW7uHX8I1OhBm7AxPV%2BaJwroDQh5ufiJMzfBeupXqpWAVwvyUKg6PcMpk4RzGttfGGLR9lk0h%2BfoKFuAC8fXw%3D%3D
    }
}