<?php
/**
 * Created by PhpStorm.
 * Author: Kam
 * Date: 2019/6/1
 * Time: 1:10
 */

namespace App\Services\Api;

use App\Utils\CreateWebAPI;
use App\Utils\CreateWebAPI\MusicState;


class MusicService extends BaseService
{
    const MIN_SONGLIST = 10;

    private $music;

    public function __construct()
    {
        $this->music = new CreateWebAPI();
    }

    public function playLists($credentials)
    {
        $data = [
            'cat' => $credentials['cat'] ?? '全部',
            'order' => $credentials['order'] ?? 'hot',
            'offset' => $credentials['offset'] ?? '0',
            'total' => $credentials['total'] ?? 'false',
            'limit' => $credentials['limit'] ?? static::MIN_SONGLIST,
//            'csrf_token' => ''
        ];
        $response = $this->music->request('music.163.com', '/weapi/playlist/list', 'POST', $data, "weapi");
        return $response;
    }

    public function album($credentials)
    {
        $data = [
            'csrf_token' => ''
        ];

        $response = $this->music->request('music.163.com', '/weapi/v1/album/' . $credentials['id'], 'POST', $data, "weapi");
        return $response;
    }

    public function ranking($credentials)
    {
        $data = [
            "id" => MusicState::RANKING_STATE[$credentials['id'] - 1][1],
            "n" => 10000,
            "csrf_token" => ""
        ];

        $response = $this->music->request('music.163.com', '/weapi/v3/playlist/detail', 'POST', $data, "weapi");
        return $response;
    }

    public function artists($credentials)
    {
        $data = [
            "csrf_token" => ""
        ];

        $response = $this->music->request('music.163.com', '/weapi/v1/artist/' . $credentials['id'], 'POST', $data, "weapi");
        return $response;
    }

    public function artistAlbum($credentials)
    {
        $data = [
            "csrf_token" => "",
            "offset" => $credentials['offset'] ?? 0,
            "total" => "true",
            "limit" => $credentials['limit'] ?? static::MIN_SONGLIST,
        ];

        $response = $this->music->request('music.163.com', '/weapi/artist/albums/' . $credentials['id'], 'POST', $data, "weapi");
        return $response;
    }

    public function artistDesc($credentials)
    {
        $data = [
            "id" => $credentials['id'],
            "csrf_token" => ""
        ];

        $response = $this->music->request('music.163.com', '/weapi/artist/introduction', 'POST', $data, "weapi");
        return $response;
    }

    public function artistMv($credentials)
    {
        $data = [
            "artistId" => $credentials['id'],
            "total" => "true",
            "offset" => $credentials['offset'] ?? 0,
            "limit" => $credentials['limit'] ?? static::MIN_SONGLIST,
            "csrf_token" => ""
        ];

        $response = $this->music->request('music.163.com', '/weapi/artist/mvs', 'POST', $data, "weapi");
        return $response;
    }

    public function songLyric($credentials)
    {
        $data = [
            "id" => $credentials['id']
        ];

        $response = $this->music->request('music.163.com', '/api/song/lyric?lv=-1&kv=-1&tv=-1', 'POST', $data, "linuxapi");
        return $response;
    }

    public function songUrl($credentials)
    {
        $data = [
            "ids" => "[" . $credentials['id'] . "]",
            "br" => intval($credentials['br'] ?? 999000)
        ];

        $response = $this->music->request('music.163.com', '/weapi/song/enhance/player/url', 'POST', $data, "weapi");
        return $response['data'][0];
    }

    public function banner($credentials)
    {
        $type = [
            0 => 'pc',
            1 => 'android',
            2 => 'iphone',
            3 => 'ipad'
        ];

        $data = [
            "clientType" => $type[$credentials['type']]
        ];

        $response = $this->music->request('music.163.com', '/api/v2/banner/get', 'POST', $data, "linuxapi");
        return $response['banners'];
    }

    public function search($credentials)
    {
// 1: 单曲, 10: 专辑, 100: 歌手, 1000: 歌单, 1002: 用户, 1004: MV, 1006: 歌词, 1009: 电台, 1014: 视频
        $type = [
            1 => '单曲',
            10 => '专辑',
            100 => '歌手',
            1000 => '歌单',
            1002 => '用户',
            1004 => 'MV',
            1006 => '歌词',
            1009 => '电台',
            1014 => '视频',
        ];

        $data = [
            "s" => $credentials['keyword'],
            "type" => $credentials['type'],
            "limit" => $credentials['limit'] ?? static::MIN_SONGLIST,
            "offset" => $credentials['offset'] ?? 0
        ];

        $response = $this->music->request('music.163.com', '/weapi/search/get', 'POST', $data, "weapi");
        return $response['result'];
    }

    public function topPlaylistDetail($credentials)
    {
        $data = [];

        $response = $this->music->request('music.163.com', '/api/playlist/detail?id=' . $credentials['id'], 'POST', $data, "weapi");
        return $response['result'];
    }

    public function songSimilar($credentials)
    {
        $data = [
            'songid' => $credentials['id'],
            "offset" => $credentials['offset'] ?? 0,
            "limit" => $credentials['limit'] ?? static::MIN_SONGLIST,
        ];

        $response = $this->music->request('music.163.com', '/weapi/v1/discovery/simiSong', 'POST', $data, "weapi");
        return $response['songs'];
    }

    public function songDetail($credentials)
    {
        // 接口修改数组参数
        $arr = explode(",", $credentials['id']);
        $c = [];
        for ($i = 0; $i < count($arr); $i++) {
//            $c .= '{"id":'.$arr[$i].'}';
            array_push($c, ['id' => $arr[$i]]);
        }
        $data = [
            'c' => json_encode($c, JSON_NUMERIC_CHECK),
            'ids' => $credentials['id'],
        ];

        $response = $this->music->request('music.163.com', '/weapi/v3/song/detail', 'POST', $data, "weapi");
        return $response;
    }

    public function mv($credentials)
    {
        // 接口修改数组参数

        $data = [
            'total' => true,
            "offset" => $credentials['offset'] ?? 0,
            "limit" => $credentials['limit'] ?? static::MIN_SONGLIST,
        ];

        $response = $this->music->request('music.163.com', '/weapi/mv/toplist', 'POST', $data, "weapi");
        return $response['data'];
    }

    public function userLogin($credentials)
    {

        $data = [
            'username' => $credentials['email'],
            'password' => md5($credentials['password']),
            'rememberLogin' => true,
        ];
        $response = $this->music->request('music.163.com', '/weapi/login', 'POST', $data, "weapi");
        return $response;
    }

    public function album_newest()
    {
        $data = [];
        $response = $this->music->request('music.163.com', '/api/discovery/newAlbum', 'POST', $data, "weapi");
        return $response;
    }

    public function album_sublist($credentials)
    {
        $data = [
            "limit" => $credentials["limit"] ?? 25,
            "offset" => $credentials["offset"] ?? 0,
            "total" => true
        ];
        $response = $this->music->request('music.163.com', '/weapi/album/sublist', 'POST', $data, "weapi");
        return $response;
    }

    public function artist_list($credentials)
    {
        /*
            categoryCode 取值
            入驻歌手 5001
            华语男歌手 1001
            华语女歌手 1002
            华语组合/乐队 1003
            欧美男歌手 2001
            欧美女歌手 2002
            欧美组合/乐队 2003
            日本男歌手 6001
            日本女歌手 6002
            日本组合/乐队 6003
            韩国男歌手 7001
            韩国女歌手 7002
            韩国组合/乐队 7003
            其他男歌手 4001
            其他女歌手 4002
            其他组合/乐队 4003

            initial 取值 a-z/A-Z
        */
        $data = [
            "categoryCode" => $credentials["categoryCode"] ?? '1001',
            "initial" => ord(strtoupper($credentials["initial"] ?? '')),
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
            "total" => true
        ];
        $response = $this->music->request('music.163.com', '/weapi/artist/list', 'POST', $data, "weapi");
        return $response;
    }

    public function artist_sub($credentials)
    {
        $data = [
            "artistId" => $credentials['id'],
            "artistIds" => '[' . $credentials['id'] . ']',
        ];
        $type = $credentials['t'] ?? '' == 1 ? 'sub' : 'unsub';
        $response = $this->music->request('music.163.com', '/weapi/artist/' . $type, 'POST', $data, "weapi");
        return $response;
    }

    public function artist_sublist($credentials)
    {
        $data = [
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/artist/sublist', 'POST', $data, "weapi");
        return $response;
    }

    public function captch_sent($credentials)
    {
        $data = [
            "ctcode" => $credentials["ctcode"] ?? '86',
            "cellphone" => $credentials["phone"],
        ];
        $response = $this->music->request('music.163.com', '/weapi/sms/captcha/sent', 'POST', $data, "weapi");
        return $response;
    }

    public function captch_verify($credentials)
    {
        $data = [
            "ctcode" => $credentials["ctcode"] ?? '86',
            "cellphone" => $credentials["phone"],
            "captcha" => $credentials["captcha"]
        ];
        $response = $this->music->request('music.163.com', '/weapi/sms/captcha/verify', 'POST', $data, "weapi");
        return $response;
    }

    public function comment_album($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/comments/R_AL_3_' . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function comment_dj($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/comments/A_DJ_1_' . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function comment_hot($credentials)
    {
        //  歌曲 、 MV 、 歌单 、 专辑 、 电台 、 视频
        $tyleList = ['R_SO_4_', 'R_MV_5_', 'A_PL_0_', 'R_AL_3_', 'A_DJ_1_', 'R_VI_62_'];
        $type = $tyleList[$credentials['type']];
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/hotcomments/' . $type . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function comment_music($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/comments/R_SO_4_' . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function comment_mv($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/comments/R_MV_5_' . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function comment_playlist($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/comments/A_PL_0_' . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function comment_video($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "offset" => $credentials["offset"] ?? 0,
            "limit" => $credentials["limit"] ?? static::MIN_SONGLIST,
        ];
        $response = $this->music->request('music.163.com', '/weapi/v1/resource/comments/R_VI_62_' . $credentials["id"], 'POST', $data, "weapi");
        return $response;
    }

    public function dj_banner()
    {
        $data = [];
        $response = $this->music->request('music.163.com', '/weapi/djradio/banner/get', 'POST', $data, "weapi");
        return $response;
    }

    public function dj_category_excludehot()
    {
        $data = [];
        $response = $this->music->request('music.163.com', '/weapi/djradio/category/excludehot', 'POST', $data, "weapi");
        return $response;
    }

    public function dj_category_recommend()
    {
        $data = [];
        $response = $this->music->request('music.163.com', '/weapi/djradio/home/category/recommend', 'POST', $data, "weapi");
        return $response;
    }

    public function dj_catelist()
    {
        $data = [];
        $response = $this->music->request('music.163.com', '/weapi/djradio/category/get', 'POST', $data, "weapi");
        return $response;
    }

    public function like($credentials)
    {
        $data = [
            "rid" => $credentials["id"],
            "like" => $credentials["like"] == 'false' ? false : true,
        ];
        $response = $this->music->request('music.163.com', '/weapi/radio/like?alg=' . $credentials["alg"] || 'itembased' . '&trackId=' . $credentials["id"] . '&time=' . $credentials['time']??25, 'POST', $data, "weapi");
        return $response;
    }

    public function login($credentials)
    {
        $data = [
            "username" => $credentials["email"],
            "password" => md5($credentials["password"]),
            "rememberLogin" => "true"
        ];
        $response = $this->music->request('music.163.com', '/weapi/login', 'POST', $data, "weapi");
        return $response;
    }


    public function login_cellphone($credentials)
    {
        $data = [
            "phone" => $credentials["phone"],
            "password" => md5($credentials["password"]),
            "countrycode" => "86",
            "rememberLogin" => "true"
        ];
        $response = $this->music->request('music.163.com', '/weapi/login/cellphone', 'POST', $data, "weapi");
        return $response;
    }









}