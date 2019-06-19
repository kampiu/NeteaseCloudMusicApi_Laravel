<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//

Route::group(['prefix' => 'v1'], function (Router $router) {
    Route::group(['prefix' => 'netmusic'], function (Router $router) {
//            1 => '单曲',  详情、URL、歌词
//            10 => '专辑',   列表、详情
//            100 => '歌手',      详情、专辑、MV、歌单
//            1000 => '歌单',        列表、类型
//            1002 => '用户',         登录
//            1004 => 'MV',
//            1006 => '歌词',
//            1009 => '电台',
//            1014 => '视频',
        // batch captch_register comment_event
        // check_music 歌曲可用性
        // comment 发送与删除评论
        // album 专辑内容
        // comment_like 点赞与取消点赞评论
        // daily_signin 签到
        // digitalAlbum_purchased 我的数字专辑
        // dj_detail 电台详情

        // dj_hot 热门电台
        // dj_paygift 付费电台
        // dj_program 电台节目列表

        // dj_program_detail 电台节目详情
        // dj_recommend 精选电台
        // dj_recommend_type 精选电台分类

        // dj_sub 订阅与取消电台
        // dj_sublist 订阅电台列表
        // dj_today_perfered dj今日优选

        // event 动态

        // event_del 删除动态
        // event_forward 转发动态
        // fm_trash 垃圾桶
        // hot_topic 热门话题
        // follow 关注与取消关注用户
        // likelist 喜欢的歌曲(无序)

        Route::any('album', 'Api\MusicController@album')->name('v1.music.getAlbum');
        // album_newest 最新专辑
        Route::any('album_newest', 'Api\MusicController@album_newest')->name('v1.music.album_newest');
        //album_sublist 已收藏专辑列表
        Route::any('album_sublist', 'Api\MusicController@album_sublist')->name('v1.music.album_sublist'); // [ 需要登录 ]
        // artist_album 歌手专辑列表
        Route::any('artist_album', 'Api\MusicController@artist_album')->name('v1.music.artist_album');
        // artist_desc 歌手介绍
        Route::any('artist_desc', 'Api\MusicController@artist_desc')->name('v1.music.artist_desc');
        // artist_list 歌手分类
        Route::any('artist_list', 'Api\MusicController@artist_list')->name('v1.music.artist_list');
        // artist_mv 歌手相关MV
        Route::any('artist_mv', 'Api\MusicController@artist_mv')->name('v1.music.artist_mv');
        // artist_sub 收藏与取消收藏歌手
        Route::any('artist_sub', 'Api\MusicController@artist_sub')->name('v1.music.artist_sub');
        // artist_sublist 关注歌手列表
        Route::any('artist_sublist', 'Api\MusicController@artist_sublist')->name('v1.music.artist_sublist');
        // artists 歌手单曲
        Route::any('artists', 'Api\MusicController@artists')->name('v1.music.artists');
        // banner 首页轮播图
        Route::any('banner', 'Api\MusicController@banner')->name('v1.music.banner');
        // captch_sent 发送验证码
        Route::any('captch_sent', 'Api\MusicController@captch_sent')->name('v1.music.captch_sent');
        // captch_verify 校验验证码
        Route::any('captch_verify', 'Api\MusicController@captch_verify')->name('v1.music.captch_verify');
        // comment_album 专辑评论
        Route::any('comment_album', 'Api\MusicController@comment_album')->name('v1.music.comment_album');
        // comment_dj 电台评论
        Route::any('comment_dj', 'Api\MusicController@comment_dj')->name('v1.music.comment_dj');
        // comment_hot 热门评论
        Route::any('comment_hot', 'Api\MusicController@comment_hot')->name('v1.music.comment_hot');
        // comment_music 歌曲评论
        Route::any('comment_music', 'Api\MusicController@comment_music')->name('v1.music.comment_music');
        // comment_mv MV评论
        Route::any('comment_mv', 'Api\MusicController@comment_mv')->name('v1.music.comment_mv');
        // comment_playlist 歌单评论
        Route::any('comment_playlist', 'Api\MusicController@comment_playlist')->name('v1.music.comment_playlist');
        // comment_video 视频评论
        Route::any('comment_video', 'Api\MusicController@comment_video')->name('v1.music.comment_video');
        // dj_banner 电台banner
        Route::any('dj_banner', 'Api\MusicController@dj_banner')->name('v1.music.dj_banner'); //  [ 暂无数据 ]
        // dj_category_excludehot dj非热门类型
        Route::any('dj_category_excludehot', 'Api\MusicController@dj_category_excludehot')->name('v1.music.dj_category_excludehot'); //  [ 暂无数据 ]
        // dj_category_recommend dj推荐类型
        Route::any('dj_category_recommend', 'Api\MusicController@dj_category_recommend')->name('v1.music.dj_category_recommend'); //  [ 暂无数据 ]
        // dj_catelist dj推荐类型
        Route::any('dj_catelist', 'Api\MusicController@dj_catelist')->name('v1.music.dj_catelist'); //  [ 暂无数据 ]
        // like 红心与取消红心歌曲
        Route::any('like', 'Api\MusicController@like')->name('v1.music.like'); // [ 需要登录 ]
        // login 邮箱登录
        Route::any('login', 'Api\MusicController@login')->name('v1.music.login');
        // login_cellphone 手机登录
        Route::any('login_cellphone', 'Api\MusicController@login_cellphone')->name('v1.music.login_cellphone');






        Route::any('playlist', 'Api\MusicController@topPlaylist')->name('v1.music.topPlaylist');
        Route::any('playlist/detail', 'Api\MusicController@topPlaylistDetail')->name('v1.music.topPlaylistDetail');
        Route::any('ranking', 'Api\MusicController@ranking')->name('v1.music.ranking');


        Route::any('song/lyric', 'Api\MusicController@songLyric')->name('v1.music.songLyric');
        Route::any('song/url', 'Api\MusicController@songUrl')->name('v1.music.songUrl');
        Route::any('song/detail', 'Api\MusicController@songDetail')->name('v1.music.songDetail');

        Route::any('search', 'Api\MusicController@search')->name('v1.music.search');
        Route::any('song/similar', 'Api\MusicController@songSimilar')->name('v1.music.songSimilar');

        Route::any('mv', 'Api\MusicController@mv')->name('v1.music.mv');


        Route::any('user/login', 'Api\MusicController@userLogin')->name('v1.music.userLogin');
//        Route::any('test', 'Api\MusicController@index')->name('v1.music.userLogin');

    });
});

