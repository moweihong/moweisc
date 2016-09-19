<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //

        'backend/shop/savePic',
        'backend/shop/delShop',
        'backend/shop/delShopPic',
        'backend/shop/getBrandid',
        'backend/shop/delBrand',
        'backend/shop/delCategory',
        'backend/shop/setStatus',

        'backend/redbao/delRedBao',
        
        'backend/rotation/updateRo',
        'backend/rotation/savePic',
            

		'share/pushcomment',
		
		'user/address/submit',
		'user/saveuserpic',
		
        'user/updateUserEmail',
        'user/updateUserPhone',
        
        'weixin/notify',
        'unionpay/result',
        'unionpay/return',
        'unionpay_m/result',
        'unionpay_m/return',

		'uploadify/up',  //上传用
		'uploadify/saveShowPic',
		'user_m/showpic',
		'user_m/savepics',
		'jiujiu/recharge',
		'backend/sym/excelImport',

	    'jdpay/redirect',
	    'jdpay/notify',

	    'api/addBean'
    ];
}
