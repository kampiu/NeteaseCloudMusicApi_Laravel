<?php
/**
 * Created by PhpStorm.
 * Author: KAM
 * Date: 2019/5/21
 * Time: 16:10
 */

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use App\Utils\ValidatorExtend;
use App\Services\Api\MusicService;

class MusicController extends BaseController
{
    const QQ_MUSIC = 'QQ音乐';
    const KUGOU_MUSIC = '酷狗音乐';
    const NET_MUSIC = '网易云音乐';

    private $client;
    private $music;

    public function __construct(MusicService $musicService)
    {
        $this->music = $musicService;
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function index()
    {
        return $this->send(20000, '...');
    }

    public function topPlaylist(Request $request)
    {
        $credentials = $request->only('cat', 'order', 'offset', 'total', 'limit');
        $rules = [
            'cat' => 'string',
            'order' => 'string',
            'offset' => 'integer',
            'total' => 'string',
            'limit' => 'integer|max:50',
        ];
        $messages = [
            'cat.string' => 'cat -> 为String类型',
            'order.string' => 'order -> 为String类型',
            'offset.integer' => 'offset -> 为Int类型',
            'total.string' => 'total -> 为String类型',
            'limit.integer' => 'limit -> 为Int类型',
            'limit.max:50' => 'limit 最大为50',
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->playLists($credentials);
        return $this->send(20000, $response);
    }

    public function album(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->album($credentials);
        return $this->send(20000, $response);
    }

    // 可加分页
    public function album_newest(Request $request)
    {
//        $credentials = $request->only('id');
//        $rules = [
//            'id' => 'required'
//        ];
//        $messages = [
//            'id.required' => '缺少ID',
//            'id.integer' => 'id -> 为Int类型'
//        ];
//        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->album_newest();
        return $this->send(20000, $response);
    }

    public function album_sublist(Request $request)
    {
        $credentials = $request->only('limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
        ];
        $messages = [
            'limit.alpha' => 'limit 为正整数',
            'offset.alpha' => 'offset 为正整数'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->album_sublist($credentials);
        return $this->send(20000, $response);
    }

    public function ranking(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->ranking($credentials);
        return $this->send(20000, $response);
    }

    public function artists(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artists($credentials);
        return $this->send(20000, $response);
    }

    public function artist_album(Request $request)
    {
        $credentials = $request->only('id', 'offset', 'limit');
        $rules = [
            'id' => 'required',
//            'offset' => 'integer',
//            'limit' => 'integer',
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artistAlbum($credentials);
        return $this->send(20000, $response);
    }

    public function artist_desc(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artistDesc($credentials);
        return $this->send(20000, $response);
    }
    // 歌手分类
    public function artist_list(Request $request)
    {
        $credentials = $request->only('limit', 'offset', 'initial', 'categoryCode');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'initial' => 'regex:/^[a-zA-Z]{1}$/',
            'categoryCode' => 'numeric'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'initial.regex' => 'initial 取值范围为 a-z A-Z',
            'categoryCode.numeric' => 'categoryCode 为正整数',
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artist_list($credentials);
        return $this->send(20000, $response);
    }

    public function artist_mv(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artistMv($credentials);
        return $this->send(20000, $response);
    }
    //artist_sub
    public function artist_sub(Request $request)
    {
        $credentials = $request->only('t', 'id');
        $rules = [
            'id' => 'required|numeric'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.numeric' => 'ID 为正整数',
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artist_sub($credentials);
        return $this->send(20000, $response);
    }
    //artist_sublist
    public function artist_sublist(Request $request)
    {
        $credentials = $request->only('limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
        ];
        $messages = [
            'limit.alpha' => 'limit 为正整数',
            'offset.alpha' => 'offset 为正整数'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->artist_sublist($credentials);
        return $this->send(20000, $response);
    }


    public function songLyric(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->songLyric($credentials);
        return $this->send(20000, $response);
    }

    public function songUrl(Request $request)
    {
        $credentials = $request->only('id', 'br');
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '缺少ID',
//            'id.integer' => 'id -> 为Int类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->songUrl($credentials);
        return $this->send(20000, $response);
    }

    public function banner(Request $request)
    {
        $credentials = $request->only('type');
        $rules = [
            'type' => 'required|max:3'
        ];
        $messages = [
            'type.required' => '缺少 广告类型',
            'type.max:3' => 'id -> 0 ~ 3'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->banner($credentials);
        return $this->send(20000, $response);
    }

    public function search(Request $request)
    {
        $credentials = $request->only('keyword', 'type', 'limit', 'offset');
        $rules = [
            'keyword' => 'required',
            'type' => 'required',
        ];
        $messages = [
            'keyword.required' => '搜索关键词',
            'type.required' => '搜索类型'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->search($credentials);
        return $this->send(20000, $response);
    }

    public function topPlaylistDetail(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required',
        ];
        $messages = [
            'id.required' => '缺少 歌单 ID'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->topPlaylistDetail($credentials);
        return $this->send(20000, $response);
    }

    public function songSimilar(Request $request)
    {
        $credentials = $request->only('id', 'offset', 'limit');
        $rules = [
            'id' => 'required',
        ];
        $messages = [
            'id.required' => '缺少 歌曲 ID'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->songSimilar($credentials);
        return $this->send(20000, $response);
    }

    public function songDetail(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required',
        ];
        $messages = [
            'id.required' => '缺少 歌曲 ID'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->songDetail($credentials);
        return $this->send(20000, $response);
    }

    public function mv(Request $request)
    {
        $credentials = $request->all();
//        $rules = [
//            'id' => 'required',
//        ];
//        $messages = [
//            'id.required' => '缺少 歌曲 ID'
//        ];
//        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->mv($credentials);
        return $this->send(20000, $response);
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->only('id');
        $rules = [
            'id' => 'required',
        ];
        $messages = [
            'id.required' => '缺少 歌曲 ID'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->songDetail($credentials);
        return $this->send(20000, $response);
    }

    public function captch_sent(Request $request)
    {
        $credentials = $request->only('phone');
        $rules = [
            'phone' => 'required|regex:/^1[3456789][0-9]{9}$/',
        ];
        $messages = [
            'phone.required' => '缺少 歌曲 ID',
            'phone.regex' => '手机号码错误'
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->captch_sent($credentials);
        return $this->send(20000, $response);
    }

    public function captch_verify(Request $request)
    {
        $credentials = $request->only('phone', 'captcha');
        $rules = [
            'phone' => 'required|regex:/^1[3456789][0-9]{9}$/',
            'captcha' => 'required',
        ];
        $messages = [
            'phone.required' => '缺少 手机号码',
            'phone.regex' => '手机号码错误',
            'captcha.required' => '缺少 验证码',
//            'captcha.regex' => '验证码格式错误',
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->captch_verify($credentials);
        return $this->send(20000, $response);
    }

    public function comment_album(Request $request)
    {
        $credentials = $request->only('id', 'limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required|numeric'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_album($credentials);
        return $this->send(20000, $response);
    }

    public function comment_dj(Request $request)
    {
        $credentials = $request->only('id', 'limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required|numeric'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_dj($credentials);
        return $this->send(20000, $response);
    }

    public function comment_hot(Request $request)
    {
        $credentials = $request->only('type', 'limit', 'offset', 'id');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required|numeric',
            'type' => 'required|regex:/^[0-5]{1}$/',
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
            'type.required' => '缺少 type',
            'type.regex' => 'type 为正整数 0-5',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_hot($credentials);
        return $this->send(20000, $response);
    }

    public function comment_music(Request $request)
    {
        $credentials = $request->only('id', 'limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required|numeric'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_music($credentials);
        return $this->send(20000, $response);
    }

    public function comment_mv(Request $request)
    {
        $credentials = $request->only('id', 'limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required|numeric'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_mv($credentials);
        return $this->send(20000, $response);
    }

    public function comment_playlist(Request $request)
    {
        $credentials = $request->only('id', 'limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required|numeric'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_playlist($credentials);
        return $this->send(20000, $response);
    }

    public function comment_video(Request $request)
    {
        $credentials = $request->only('id', 'limit', 'offset');
        $rules = [
            'limit' => 'numeric',
            'offset' => 'numeric',
            'id' => 'required'
        ];
        $messages = [
            'limit.numeric' => 'limit 为正整数',
            'offset.numeric' => 'offset 为正整数',
            'id.required' => '缺少 ID',
//            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->comment_video($credentials);
        return $this->send(20000, $response);
    }

    public function dj_banner(Request $request)
    {
        $response = $this->music->dj_banner();
        return $this->send(20000, $response);
    }

    public function dj_category_excludehot(Request $request)
    {
        $response = $this->music->dj_category_excludehot();
        return $this->send(20000, $response);
    }

    public function dj_category_recommend(Request $request)
    {
        $response = $this->music->dj_category_recommend();
        return $this->send(20000, $response);
    }

    public function dj_catelist(Request $request)
    {
        $response = $this->music->dj_catelist();
        return $this->send(20000, $response);
    }

    public function like(Request $request)
    {
        $credentials = $request->only('id', 'like');
        $rules = [
            'id' => 'required|numeric'
        ];
        $messages = [
            'id.required' => '缺少 ID',
            'id.numeric' => 'ID 为正整数',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->like($credentials);
        return $this->send(20000, $response);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required' => '缺少邮箱',
            'email.email' => '邮箱格式不正确',
            'password.required' => '请填写密码',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->login($credentials);
        return $this->send(20000, $response);
    }

    public function login_cellphone(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        $rules = [
            'phone' => 'required|regex:/^1[3456789][0-9]{9}$/',
            'password' => 'required'
        ];
        $messages = [
            'phone.required' => '缺少手机号码',
            'phone.regex' => '手机号码格式不正确',
            'password.required' => '请填写密码',
        ];;
        ValidatorExtend::validate($credentials, $rules, $messages);
        $response = $this->music->login_cellphone($credentials);
        return $this->send(20000, $response);
    }












    public function getQQMusic(Request $request)
    {
        $credentials = $request->only('word');
        $rules = [
            'word' => 'required|string|max:32',
        ];
        $messages = [
            'word.required' => '请输入搜索内容',
            'word.string' => '搜索内容为字符串',
            'word.max:32' => '搜索内容最长32位',
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);

        $url = 'https://c.y.qq.com/soso/fcgi-bin/search_for_qq_cp?format=json&w=' . $credentials['word'] . '&n=20&p=1';

        $list = $this->client->request('get', $url, [
            'timeout' => 10,
            'headers' => [
                'Referer' => 'https://y.qq.com/m/index.html'
            ]
        ])->getBody();
        $res = json_decode($list, true);
        $data = $res['data']['song']['list'];
        $result = [];
        foreach ($data as $key => $val) {
            array_push($result, [
                'music_type' => 'QQ_MUSIC',
                'name' => $val['songname'],
                'id' => $val['songid'],
                'albumid' => $val['albumid'],
                'albumname' => $val['albumname'],
                'singer' => [
                    'id' => $val['singer'][0]['id'],
                    'name' => $val['singer'][0]['name']
                ]
            ]);
        }
        return $this->send(20000, $result);
    }

    public function getKuGouMusic(Request $request)
    {
        $credentials = $request->only('word');
        $rules = [
            'word' => 'required|string|max:32',
        ];
        $messages = [
            'word.required' => '请输入搜索内容',
            'word.string' => '搜索内容为字符串',
            'word.max:32' => '搜索内容最长32位',
        ];
        ValidatorExtend::validate($credentials, $rules, $messages);

        $url = 'http://songsearch.kugou.com/song_search_v2?keyword=' . $credentials['word'] . '&page=1&pagesize=20&platform=WebFilter';

        $list = $this->client->request('get', $url, [
            'timeout' => 10
        ])->getBody();
        $res = json_decode($list, true);
        $data = $res['data']['lists'];
        $result = [];
        foreach ($data as $key => $val) {
            array_push($result, [
                'music_type' => 'KUGOU_MUSIC',
                'name' => $val['SongName'],
                'id' => $val['ID'],
                'albumid' => $val['AlbumID'],
                'albumname' => $val['AlbumName'],
                'singer' => [
                    'id' => $val['SingerId'][0],
                    'name' => $val['SingerName']
                ]
            ]);
        }
        return $this->send(20000, $result);
    }

    public function getNetMusic()
    {

    }


}