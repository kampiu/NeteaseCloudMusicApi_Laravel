<?php
/**
 * Created by PhpStorm.
 * Author: KAM
 * Date: 2019/5/25
 * Time: 10:45
 */

namespace App\Utils;

use App\Utils\CreateWebAPI\Encrypt;
use GuzzleHttp\Client;

class CreateWebAPI
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function index()
    {

    }

    /**
     * 随机UA信息
     * Author: KAM
     * Date: 2019/5/31 14:04
     * @return array
     */
    public static function getUserAgent()
    {
        $UserAgentList = [
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1",
            "Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Mobile Safari/537.36",
            "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Mobile Safari/537.36",
            "Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LYZ28E) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Mobile Safari/537.36",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_2 like Mac OS X) AppleWebKit/603.2.4 (KHTML, like Gecko) Mobile/14F89;GameHelper",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 10_0 like Mac OS X) AppleWebKit/602.1.38 (KHTML, like Gecko) Version/10.0 Mobile/14A300 Safari/602.1",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:46.0) Gecko/20100101 Firefox/46.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:46.0) Gecko/20100101 Firefox/46.0",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
            "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Win64; x64; Trident/6.0)",
            "Mozilla/5.0 (Windows NT 6.3; Win64, x64; Trident/7.0; rv:11.0) like Gecko",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/13.10586",
            "Mozilla/5.0 (iPad; CPU OS 10_0 like Mac OS X) AppleWebKit/602.1.38 (KHTML, like Gecko) Version/10.0 Mobile/14A300 Safari/602.1"
        ];
        return $UserAgentList[rand(0, count($UserAgentList) - 1)];
    }

    public static function randomString($count)
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKMNOPQRSTUVWXYZ\/+';
        $res = '';
        while ($count--) {
            $res .= $str[rand(0, strlen($str) - 1)];
        }
        return $res;
    }

    public static function getMillisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectimes = substr($msectime, 0, 13);
    }

    public static function getCookie()
    {
        $jsessionid = static::randomString(176) . ':' . static::getMillisecond();
        $nuid = static::randomString(32);
        return 'JSESSIONID-WYYY=' . $jsessionid . '; _iuqxldmzr_=32; _ntes_nnid=' . $nuid . ',' . static::getMillisecond() . '}; _ntes_nuid=' . $nuid;
    }

    public function weapi($host, $path, $method, $data)
    {
        $options = [
            'timeout' => 10,
            'headers' => [
                'Accept' => '*/*',
                'Accept-Language' => 'zh-CN,zh;q=0.8,gl;q=0.6,zh-TW;q=0.4',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Referer' => 'http://music.163.com',
                'Host' => 'music.163.com',
                'Cookie' => static::getCookie(),
                'User-Agent' => static::getUserAgent()
            ],
            'body' => Encrypt::enctypt($data)
        ];

        $response = $this->client->request($method, 'https://' . $host . $path, $options)->getBody();
//        dd($response);
//        die;
        return json_decode($response, true);
    }

    public function linuxapi($host, $path, $method, $data)
    {
        $en = [
            "method" => $method,
            "url" => 'https://'.$host.$path,
            "params" => $data
        ];
        $options = [
            'timeout' => 10,
            'headers' => [
                'Accept' => '*/*',
                'Accept-Language' => 'zh-CN,zh;q=0.8,gl;q=0.6,zh-TW;q=0.4',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Referer' => 'http://music.163.com',
                'Host' => 'music.163.com',
                'Cookie' => static::getCookie(),
                'User-Agent' => static::getUserAgent()
            ],
            'body' => 'eparams=' . Encrypt::eapi($en)
        ];
        $response = $this->client->request($method, 'https://music.163.com/api/linux/forward', $options)->getBody();
        return json_decode($response, true);
    }

    public function eapi($host = 'music.163.com', $path = '', $method = 'POST', $data)
    {
        return "";
    }

    public function request($host = 'music.163.com', $path = '', $method = 'POST', $data, $crypto)
    {
        switch ($crypto) {
            case "weapi":
                $response = $this->weapi($host, $path, $method, $data);
                break;
            case "linuxapi":
                $response = $this->linuxapi($host, $path, $method, $data);
                break;
            case "eapi":
                $response = $this->eapi($host = 'music.163.com', $path = '', $method = 'POST', $data);
                break;
            default:
                $response = $this->weapi($host = 'music.163.com', $path = '', $method = 'POST', $data);
        }
//        dd($response);
//        die;

        return $response;
    }


}