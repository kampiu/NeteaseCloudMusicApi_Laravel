<?php
/**
 * Created by PhpStorm.
 * User: Kam
 * Date: 2019/4/14
 * Time: 17:37
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User;

class WebController extends Controller
{
    public function index(Request $request){
        $user = User::all();
        return view('user', ['user' => $user]);
    }
}