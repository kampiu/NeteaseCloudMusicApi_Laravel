<?php
/**
 * Created by PhpStorm.
 * User: Kam
 * Date: 2019/4/14
 * Time: 23:31
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;

class BaseController extends Controller
{
    use HasResourceActions;
    protected $model;
}
