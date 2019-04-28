<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Sec;

use phpseclib\Crypt\AES;

class Decrypter
{
    protected $iv = '0102030405060708';
    protected $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * 实例化 然后调这个方法
     * @param string $data
     * @return array
     */
    public function decrypt(string $data): array
    {
        $secret = $this->decode();
        $key = $this->getKey($secret);
        $cipher = new AES();
        $cipher->setKey($key);
        $cipher->setIV($this->iv);
        $result = $cipher->decrypt($data);
        if (mb_detect_encoding($result) != 'UTF-8') {
            $result = mb_convert_encoding($result, 'UTF-8');
        }
        return \GuzzleHttp\json_decode($this->specialFilter($result), true);
    }

    protected function decode(): string
    {
        return base64_decode(urldecode($this->secret));
    }

    protected function getKey(string $secret): string {
        $result = substr($secret, 0, 16);
        $len = strlen($result);
        for ($i = 0; $i < 16-$len; $i++) {
            $result .= '0';
        }
        return $result;
    }

    /**
     * 这是有赞大佬给我的
     * 过滤ASCII码
     * @param $string
     * @return string
     */
    protected static function specialFilter($string){
        if(!$string) return '';

        $new_string = '';
        for($i =0; isset($string[$i]); $i++){
            $asc_code = ord($string[$i]);    //得到其asc码

            //以下代码旨在过滤非法字符
            if($asc_code == 9 || $asc_code == 10 || $asc_code == 13){
                $new_string .= ' ';
            }else if($asc_code > 31 && $asc_code != 127){
                $new_string .= $string[$i];
            }
        }

        return trim($new_string);
    }
}