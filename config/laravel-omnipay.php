<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],
        'unionpay' => [
            'driver' => 'UnionPay_Express',
            'options' => [
                    'merId' => '898440373990106',   //777290058120462
                    'certPath' => '/data001/unionpay/rsa.pfx',
                    'certPassword' =>'111111',
                    'certDir'=>'/data001/unionpay/',
                    'returnUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/unionpay/return',
                    'notifyUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/unionpay/result',
                    'environment' => 'production'
            ]
        ],
        'unionpay_m' => [
                'driver' => 'UnionPay_Express',
                'options' => [
                        'merId' => '898440373990106',   //777290058120462
                        'certPath' => '/data001/unionpay/rsa.pfx',
                        'certPassword' =>'111111',
                        'certDir'=>'/data001/unionpay/',
                        'returnUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/unionpay_m/return',
                        'notifyUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/unionpay_m/result',
                        'environment' => 'production'
                ]
        ],
	    'alipay_m' => [
    	        'driver' => 'Alipay_WapExpress',
    	        'options' => [
    	                'partner' => '2088021882016488',
    	                'key' => 't7gaq681fe8oj1kwryzc1pkem2vmuz2n',
    	                'sellerEmail' => '2981761170@qq.com',
    	                'returnUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/alipay_m/return',
    	                'notifyUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/alipay_m/result',
    	                'privateKey' => '/data001/alipay/rsa_private_key.pem'
    	        ]    
	    ],
        'weixin_m' => [
                'driver' => 'WechatPay_Js',
                'options' => [
                        
                ]
        ],
        'weixin_app' => [
                'driver' => 'WechatPay_App',
                'options' => [
        
                ]
        ],
	]

];