<?php
namespace App\Http\Controllers\h5\View;
use Illuminate\Routing\Controller as BaseController;

class StaticHtmlController extends BaseController
{
	//关于我们
    public function aboutus()
    { 
        return view('h5.aboutus_m');
    }
  
}
