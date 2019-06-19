<?php
/**
 * Created by PhpStorm.
 * Author: Administrator
 * Date: 2019/5/16
 * Time: 15:51
 */

namespace App\Utils;


class Response
{
    const RESPONSE_CODE = [
        //请求成功
        '20000' => '操作成功',
        //未登录
        '30000' => '操作失败',
        '30400' => '登录超时',
        '30401' => '账号不存',
        '30402' => '密码错误',
        '30403' => '验证码错误',
        '30404' => '账号已存在',
        '30405' => '请登录',
        //请求失败
        '40000' => '操作失败',
        '40400' => '登录失败',
    ];


    public static function successJson($code = '20000', $data = [], $message = null)
    {
        return response()->json([
            'status' => $code,
            'msg' => $message??static::RESPONSE_CODE[$code],
            'data' => $data,
            'timestamp' => time()
        ]);
    }
}