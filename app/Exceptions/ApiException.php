<?php
/**
 * Created by PhpStorm.
 * Author: Administrator
 * Date: 2019/5/13
 * Time: 15:29
 */

namespace App\Exceptions;

use Exception;
use App\Utils\Response;

class ApiException extends Exception
{
    public function render()
    {
        return Response::successJson($this->getCode(), [], $this->getMessage() ?? null);
    }


}