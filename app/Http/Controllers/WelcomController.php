<?php
namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

use App\Http\Requests;
use Request;

class WelcomController extends Controller {
    public function index($id){echo $id;
        return view('welcom');
    }
    
    public function getCreate(){
        var_dump(Request::input());
    }
}