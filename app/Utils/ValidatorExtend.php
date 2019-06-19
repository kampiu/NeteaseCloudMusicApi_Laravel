<?php
/**
 * Created by PhpStorm.
 * Author: Administrator
 * Date: 2019/5/10
 * Time: 17:46
 */

namespace App\Utils;

use App\Exceptions\WrongException;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ApiException;

class ValidatorExtend
{
    public function render()
    {
        $validateExtend = new ValidatorExtend();
    }

    public static function validate(array $data, array $rules, array $messages)
    {
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {  //判断验证是否失败
            throw new ApiException($validator->errors()->first(), 40000);
        }
        return true;
    }
}