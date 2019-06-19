<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/15
 * Time: 13:46
 */

namespace App\Services\Api;

use Illuminate\Support\Facades\Facade;

abstract class BaseService extends Facade
{

    public function index(){

    }

//    protected static function getFacadeAccessor()
//    {
//        return new static();
//    }
//
//    public function __call($method, $parameters)
//    {
//        return (new static)->$method(...$parameters);
//    }
//
//    public static function __callStatic($method, $parameters)
//    {
//        return (new static)->$method(...$parameters);
//    }


}