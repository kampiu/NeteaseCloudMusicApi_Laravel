<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/15
 * Time: 13:40
 */

namespace App\Http\Controllers\Api;

use App\Utils\Response;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    public function send($state = 20000, $data = [], $message = null){
        return Response::successJson($state, $data, $message);
    }


}