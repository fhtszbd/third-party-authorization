<?php
namespace App\Http\Controllers\DING;

use App\Http\Controllers\Controller;

class DingController extends Controller
{
    public function auth()
    {
        $data = ["url" => 'http://47.116.78.231?code='];
        return view('ding.auth', $data);
    }
}
