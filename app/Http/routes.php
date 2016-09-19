<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//Route::get('/', function () {
//	return view('foreground.maintain');
//});


////基础中间件过滤路由组
//Route::group(['middleware' => 'web'], function () {
////     Route::auth();
//    //后台系统路由
//    Route::group(['prefix'=>'backend', 'middleware' => 'auth'], function() {
//
//        /**栏目管理路由start**/
//        Route::get('shop/category', 'Backend\ShopController@category');
//		Route::get('shop/upCategory/{id}', 'Backend\ShopController@upCategory');
//		Route::post('shop/dealUpCategory', 'Backend\ShopController@dealUpCategory');
//		Route::post('shop/delCategory', 'Backend\ShopController@delCategory');
//		Route::get('shop/category', 'Backend\ShopController@category');
//		Route::get('shop/addCategory/{id}', 'Backend\ShopController@addCategory');
//		Route::post('shop/saveCategory', 'Backend\ShopController@saveCategory');
//		/**栏目管理路由end**/
//
//		/**品牌路由 start***/
//		Route::get('shop/brand', 'Backend\ShopController@brand');
//		Route::get('shop/addBrand', 'Backend\ShopController@addBrand');
//		Route::post('shop/saveBrand', 'Backend\ShopController@saveBrand');
//		Route::post('shop/delBrand/', 'Backend\ShopController@delBrand');
//		Route::get('shop/upBrand/{id}', 'Backend\ShopController@upBrand');
//		Route::post('shop/dealUpBrand/', 'Backend\ShopController@dealUpBrand');
//		Route::any('shop/getBrandid', 'Backend\ShopController@getBrandid');
//		/**品牌路由 end***/
//
//		/**商品管理 route start*******/
//
//		Route::get('shop/lookShop/{id}', 'Backend\ShopController@lookShop');
//		Route::get('shop/addShop', 'Backend\ShopController@addShop');
//		Route::post('shop/delShop/', 'Backend\ShopController@delShop');
//		Route::post('shop/delShopPic', 'Backend\ShopController@delShopPic');
//		Route::get('shop/upShop/{id}', 'Backend\ShopController@upShop');
//		Route::post('shop/dealUpShop', 'Backend\ShopController@dealUpShop');
//		Route::get('shop/loadUoloadShopAgain/{id}', 'Backend\ShopController@loadUoloadShopAgain');
//		Route::post('shop/uploadShopAgain', 'Backend\ShopController@uploadShopAgain');
//		Route::any('shop/saveShop', 'Backend\ShopController@saveShop');
//		Route::any('shop/savePic', 'Backend\ShopController@savePic');
//		Route::get('shop/activityList', 'Backend\ShopController@activityList');
//		Route::get('shop/addActivityShop', 'Backend\ShopController@addActivityShop');
//		Route::get('shop/searchShop/{keyword}', 'Backend\ShopController@searchShop');
//		Route::post('shop/saveActivityShop', 'Backend\ShopController@saveActivityShop');
//		Route::post('shop/setStatus', 'Backend\ShopController@setStatus');
//
//
//
//		Route::resource('shop', 'Backend\ShopController');
//        /**商品管理 route end********/
//
//        /**红包管理 route start*******/
//        Route::get('redbao/getList', 'Backend\RedbaoController@getList');
//		Route::get('redbao/addRedbao', 'Backend\RedbaoController@addRedBao');
//		Route::post('redbao/saveRedBao', 'Backend\RedbaoController@saveRedBao');
//		Route::post('redbao/delRedBao', 'Backend\RedbaoController@delRedBao');
//		Route::get('redbao/upRedbao/{id}', 'Backend\RedbaoController@upRedbao');
//		Route::post('redbao/delUpdateRedBao', 'Backend\RedbaoController@delUpdateRedBao');
//
//		/**红包管理 route end********/
//
//		/**界面管理 route start*******/
//		Route::resource('navigation', 'Backend\NavigationController');  //导航条管理
//		Route::post('rotation/savePic', 'Backend\RotationController@savePic');  //轮播图上传
//		Route::get('rotation/editRo/{id}', 'Backend\RotationController@editRo');  //加载更新页
//		Route::get('rotation', 'Backend\RotationController@index');  //轮播图列表
//		Route::get('rotation/deleteRo/{id}', 'Backend\RotationController@deleteRo');  //删除
//		Route::post('rotation/updateRo', 'Backend\RotationController@updateRo');  //更新
//		Route::post('rotation/setorder', 'Backend\RotationController@setOrder');  //轮播图设置显示顺序
//		Route::post('rotation/setshow', 'Backend\RotationController@setShow');  //轮播图设置
//		Route::resource('rotation', 'Backend\RotationController');  //轮播图管理
//		/**界面管理 route end********/
//
//        Route::resource('home', 'Backend\HomeController');
//        Route::resource('admin', 'Backend\AdminController');
//        Route::get('article', 'Backend\ArticleController@index');//显示所有文章分类
//        Route::get('article/addarticlecat', 'Backend\ArticleController@addArticleCat');//添加文章分类
//        Route::post('article/storearticlecat', 'Backend\ArticleController@storeArticleCat');//保存文章分类
//        Route::post('article/delarticlecat', 'Backend\ArticleController@delArticleCat');//删除文章分类
//        Route::get('article/showarticles', 'Backend\ArticleController@showArticles');//显示所有文章
//        Route::get('article/addarticle', 'Backend\ArticleController@addArticle');//添加文章
//        Route::post('article/storearticle', 'Backend\ArticleController@storeArticle');//保存文章
//        Route::get('article/editarticle/{id}', 'Backend\ArticleController@editArticle');//编辑文章
//        Route::post('article/delarticle', 'Backend\ArticleController@delArticle');//删除文章
//        Route::get('article/editarticlecat/{id}', 'Backend\ArticleController@editArticleCat');//文章分类编辑
//        Route::post('member/uplevel', 'Backend\MemberController@upLevel');//用户升级为渠道用户
//        Route::get('member/showorder', 'Backend\MemberController@showOrder');//显示所有晒单记录
//        Route::post('member/setShoworderSort', 'Backend\MemberController@setShoworderSort');//设置晒单排序
//        Route::post('member/checkshoworder', 'Backend\MemberController@checkShowOrder');//审核晒单
//        Route::post('member/refused', 'Backend\MemberController@refused');//提交晒单审核不通过原因
//        Route::post('member/setFengHao', 'Backend\MemberController@setFengHao');//提交晒单审核不通过原因
//        Route::get('member/showorderdetail/{id}/{sd_gid}', 'Backend\MemberController@showOrderDetail');//晒单详情
//        Route::any('member/muchPhoneSearch', 'Backend\MemberController@muchPhoneSearch');//手机批量搜索
//        Route::get('member/exportUser', 'Backend\MemberController@exportUser');//用户信息导表
//
//
//
//        Route::get('member/friendlink', 'Backend\MemberController@showFriendlink');//友情链接
//        Route::get('member/addfriendlink', 'Backend\MemberController@addFriendlink');//添加友情链接
//        Route::get('member/editfriendlink/{id}', 'Backend\MemberController@editFriendlink');//编辑友情链接
//        Route::post('member/savefriendlink', 'Backend\MemberController@saveFriendlink');//保存友情链接
//        Route::post('member/delfriendlink', 'Backend\MemberController@delFriendlink');//删除友情链接
//        Route::post('member/unsafeuse/markunsafe', 'Backend\MemberController@markAllUnsafe');//标记所有好友为异常 16.6.20 by byl
//        Route::get('member/unsafeuse/{username?}', 'Backend\MemberController@unsafeUser');//异常用户管理 16.6.20 by byl
//        Route::get('member/{username?}', 'Backend\MemberController@index');//用户显示
//        Route::any('order', 'Backend\OrderController@index');//订单管理
//        Route::any('order/getprize', 'Backend\OrderController@getprizeorder');//领取奖励的订单
//        Route::post('order/cheackorder', 'Backend\OrderController@cheackOrder');//订单审查
//		Route::post('order/takeorder', 'Backend\OrderController@takeOrder');//自提订单
//        Route::get('order/orderlook/{id}', 'Backend\OrderController@orderLook');//订单详情
//        Route::get('order/orderdayin/{id}', 'Backend\OrderController@orderdayin');//订单打印
//        Route::get('order/orderdayinp/{id}', 'Backend\OrderController@orderdayinp');//活动打印
//        Route::post('order/unsetSearch', 'Backend\OrderController@unsetSearch');//重置搜索条件
//        Route::get('order/daoBiao', 'Backend\OrderController@daoBiao');//导表
//        Route::any('order/sendGood', 'Backend\OrderController@sendGood');//发货
//        Route::get('bank', 'Backend\MemberController@withdrawCash');//佣金提现
//        Route::post('bank/checkpass', 'Backend\MemberController@checkPass');//打款
//        Route::post('bank/checkrefuse', 'Backend\MemberController@checkRefuse');//拒绝打款
//		Route::resource('lottery', 'Backend\LotteryController');
//
//
//		//含抵扣订单
//		Route::any('order/ordernew', 'Backend\OrdernewController@index');//订单详情
//		Route::any('order/unsetSearchOrdernew', 'Backend\OrdernewController@unsetSearchOrdernew');//重置搜索条件
//		Route::get('order/daoBiaonew', 'Backend\OrdernewController@daoBiaonew');//导表
//		//推广渠道管理
//		Route::get('promote', 'Backend\PromoteController@index');//充值卡状态列表
//		Route::post('promote/search', 'Backend\PromoteController@search');//充值卡查询
//		Route::get('promote/userIndex', 'Backend\PromoteController@userIndex');//推广员列表
//		Route::get('promote/searchUser/{mobile}', 'Backend\PromoteController@searchUser');//推广员查询
//		Route::get('promote/addUser', 'Backend\PromoteController@addUser');//推广员新增
//		Route::post('promote/plUpdata', 'Backend\PromoteController@plUpdata');//批量操作解冻、冻结
//		Route::get('promote/upIsJiedong','Backend\PromoteController@upIsJiedong');//单个操作解冻、冻结
//		Route::get('promote/addUserCardNum','Backend\PromoteController@addUserCardNum');//添加卡数
//		Route::get('promote/testUser','Backend\PromoteController@testUser');//检测用户是否添加了
//
//		//财务对账
//		Route::get('finance/chage', 'Backend\FinanceController@chage');//充值记录
//		Route::get('finance/buy', 'Backend\FinanceController@buy');//消费记录
//		Route::get('finance/lottery', 'Backend\FinanceController@lottery');//中奖记录
//		Route::any('finance/search', 'Backend\FinanceController@search');//搜索记录
//		Route::any('finance/export', 'Backend\FinanceController@export');//财务导表
//		Route::any('finance/tongji', 'Backend\FinanceController@tongji');//数据统计
//
//        //话费充值管理
//		Route::get('huafei/recharge', 'Backend\HuafeiController@index');//中奖话费充值列表
//		//商品数据导入
//		//Route::get('goodsImport', 'Backend\ImportController@index');
//    });
//
//    //后台登陆注册路由
//    Route::controllers([
//            'auth' => 'Auth\AuthController',
//            'password' => 'Auth\PasswordController',
//    ]);
//
//    //前台路由
//    if(strpos($_SERVER['SERVER_NAME'], 'm.ts1kg.com') !== false){
//        Route::get('/', 'h5\View\IndexController@index');//首页
//    }else{
//        Route::resource('/', 'Foreground\View\IndexController');//默认首页
//    }
//    Route::get('index', 'Foreground\View\IndexController@index');//首页
//    Route::get('guide','Foreground\View\IndexController@guide');//新手指南页面
//    Route::post('jiujiu/recharge','Foreground\View\IndexController@recharge');//99自动充值回调接口
//    Route::get('announcement','Foreground\View\IndexController@announcement');//最新揭晓页面
//    Route::get('customer', 'Foreground\View\IndexController@customer');//客服页面
//    Route::get('help/{id}', 'Foreground\View\IndexController@help');//帮助页面
//    Route::get('link', 'Foreground\View\IndexController@friendLink');//友情链接
//    Route::get('notice/{id}', 'Foreground\View\IndexController@noticeBoard');//公告
//    Route::get('getLatestRecord', 'Foreground\View\IndexController@getLatestRecord');//获取最新一百条购买记录
//    Route::get('getHistoryRecord', 'Foreground\View\IndexController@getHistoryRecord');//获取历史购买记录
//    Route::any('searchRecord', 'Foreground\View\IndexController@searchRecord');//查询历史购买记录
//    Route::get('search/{type?}/{p?}', 'Foreground\View\ProductsController@search');//搜索页
//    Route::get('app', 'Foreground\View\IndexController@app');//APP下载页
//
//    Route::get('login', 'Foreground\View\AuthController@login');
//    Route::get('register', 'Foreground\View\AuthController@register');
//    Route::get('binduser', 'Foreground\View\AuthController@binduser');
//    Route::get('register_for_test', 'Foreground\View\AuthController@register_for_test');//测试注册接口
//
//    Route::post('checkMobileExist', 'Foreground\Service\AuthController@checkMobileExist');
//
//    Route::get('forgetpwd', 'Foreground\View\AuthController@forgetpwd');
//    Route::get('captcha/{tmp}', 'Foreground\View\AuthController@captcha');
//    Route::post('checkCaptcha', 'Foreground\Service\AuthController@checkCaptcha');
//    Route::post('checkVerifyCode', 'Foreground\Service\AuthController@checkVerifyCode');
//    Route::post('setPass', 'Foreground\Service\AuthController@setPass');
//
//    Route::get('destory_login','Foreground\Service\AuthController@destoryLogin');//注销登陆
//
//    Route::get('product/{id}', 'Foreground\View\ProductsController@product');//商品详情
//    Route::get('category', 'Foreground\View\ProductsController@productCatgory');//商品所有分类
//
//    Route::get('freeday', 'Foreground\View\FreeDayController@index');//天天免费
//    Route::get('makeMoney', 'Foreground\View\MakeMoneyController@makeMoney');//我要赚钱
//
//	//他人主页
//	Route::get('him/{usrid}', 'Foreground\View\HimController@index');//他人首页
//	Route::get('him/prize/{usrid}', 'Foreground\View\HimController@prizeRecord');//中奖记录
//	Route::get('him/buy/{usrid}', 'Foreground\View\HimController@buyRecord');//购买记录
//	Route::get('him/show/{usrid}', 'Foreground\View\HimController@show');//晒单列表
//    /**ajax 分解首页**/
//    Route::get('index/getlatest','Foreground\Service\IndexController@getLatest');//获取最新揭晓商品
//    Route::get('index/getlatest_m','Foreground\Service\IndexController@getLatest_m');//获取最新揭晓商品
//	Route::get('index/checklatest','Foreground\Service\IndexController@checkLatest');//获取最新揭晓商品
//    Route::get('index/checklatest_m','Foreground\Service\IndexController@checkLatest_m');//获取最新揭晓商品
//    Route::get('index/getLotteryResult','Foreground\Service\IndexController@getLotteryResult');//获取最新揭晓商品
//    Route::get('index/getsoon','Foreground\Service\IndexController@getSoon');//获取热门商品
//    Route::get('index/getisbuy','Foreground\Service\IndexController@getIsbuy');//获取正在购买用户
//    Route::get('index/getall','Foreground\Service\IndexController@getAll');//获取所有商品
//    Route::get('index/getnew','Foreground\Service\IndexController@getNew');//获取新品上架
//    Route::get('index/getshow','Foreground\Service\IndexController@getShow');//获取晒单分享
//    Route::get('index/getfooter','Foreground\Service\IndexController@getFooter');//获取底部导航
//    Route::get('index/getnavigata','Foreground\Service\IndexController@getNavigata');//获取全部商品导航
//    Route::get('index/getarticles','Foreground\Service\IndexController@getArticles');//获取文章
//    Route::get('product/getbuyrecord/{id}','Foreground\Service\ProductsController@getAllBuyRecord');//获取该商品所有用户的购买信息
//    Route::get('product/getshoworder/{id}','Foreground\Service\ProductsController@getShowOrders');//获取该商品的晒单信息
//    Route::get('index/getheader','Foreground\Service\IndexController@getAllNavigata');//获取所有导航
//
//    /**ajax 查询信息操作**/
//    Route::get('product/checkstatus/{id}','Foreground\Service\ProductsController@getGoodsStatus');//获取商品是否已经开奖
//
//
//    Route::get('activity', 'Foreground\View\ActivityController@index');//活动发现
//    Route::get('news/{id}', 'Foreground\View\ActivityController@newsDetail');//新闻
//    Route::get('newslist', 'Foreground\View\ActivityController@newsList');//新闻列表
//    Route::post('activity/sendMessage', 'Foreground\Service\ActivityController@sendMessage');//活动发现-发送短信
//    Route::post('activity/sendPayMessage', 'Foreground\Service\ActivityController@paySms');//活动发现-收费发送短信
//    Route::get('activity/search', 'Foreground\Service\ActivityController@search');//活动发现-收费发送短信
//
//    Route::post('category/postdata','Foreground\Service\ProductsController@postData');//获取商品分类页面所有信息
//    Route::post('register', 'Foreground\Service\AuthController@register');
//    Route::post('binduser', 'Foreground\Service\AuthController@bindUser');//第三方绑定 有账户的 by byl
//    Route::post('mobileSendCode', 'Foreground\Service\AuthController@mobileSendCode');//第三方绑定 有账户的 by byl
//    Route::post('bindnouser', 'Foreground\Service\AuthController@bindNoUser');//第三方绑定 无账户 by byl
//    Route::get('wxcallback', 'Foreground\Service\AuthController@wxCallBack');//微信登陆回调接口 by  baoyaoling
//    Route::get('centercallback', 'Foreground\Service\AuthController@wxCenterCallBack');//用户中心绑定微信回调接口 16.6.16  by  baoyaoling
//    Route::get('centerqqcallback', 'Foreground\Service\AuthController@qqCenterCallBack');//用户中心绑定qq回调接口 16.6.16 by  baoyaoling
//    Route::get('qqcallback', 'Foreground\Service\AuthController@qqCallBack');//qq登陆回调接口 by  baoyaoling
//    Route::post('login', 'Foreground\Service\AuthController@login');
//    Route::post('checkMobileExist', 'Foreground\Service\AuthController@checkMobileExist');
//    Route::post('upload', 'Foreground\Service\AuthController@checkMobileExist');
//
//
//    Route::get('share', 'Foreground\View\ShareController@index');//晒单分享
//    Route::get('sharedetail/{id}', 'Foreground\View\ShareController@sharedetail');//具体某个晒单详情
//    Route::post('user/getFund', 'Foreground\View\UserController@getFund');//我的账户 - 计算公益基金
//
//
//	Route::post('uploadify/up','Foreground\Service\UploadifyController@up'); //上传组件
//	Route::post('uploadify/saveShowPic', 'Foreground\Service\UploadifyController@saveShowPic');//上传晒单图片
//
//	/**支付回调start**/
//	//微信支付回调
//	Route::post('weixin/notify', 'Foreground\Service\WxPayController@notify');
//	//银联支付回调
//	Route::post('unionpay/result', 'Foreground\Service\UnionPayController@result');
//	/**支付回调end**/
//
//	Route::post('regverify', 'Foreground\Service\AuthController@sendSmsCode');  //注册验证码
//	Route::post('regverify_set', 'Foreground\Service\AuthController@sendSmsCodeForget');  //注册验证码
//
//	//百度验证
//	Route::get('baidu_verify_4zCV23vqqg.html', function(){return view('baidu_verify_4zCV23vqqg');});
//
//	//获取服务器时间
//	Route::get('getsystime', 'Foreground\View\IndexController@getSysTime');
//
//	/*API接口*/
//	Route::get('getCpsResult', 'api\CpsController@getCpsResult');
//});
//
//
//
///*------------------------------------------------------------------------------------------*/
///*---------------------------------H5路由开始-----------------------------------------------*/
///*------------------------------------------------------------------------------------------*/
//Route::group(['middleware' =>'web_with_login_m'], function () {
//    //用户中心
//    Route::get('user_m/security', 'h5\View\UserController@securityCenter');//安全设置
//    Route::get('user_m/updatepwd', 'h5\View\UserController@updatePwd');//安全中心修改密码
//    Route::post('user_m/updatepwd', 'h5\View\UserController@updatePassWord');//安全中心修改密码
//    Route::get('user_m/123', 'h5\View\UserController@getUserByjava');//安全中心修改密码
//    Route::get('user_m/bindtel', 'h5\View\UserController@bindtel');//绑定手机
//    Route::post('user_m/sendcode', 'h5\View\UserController@sendCode');//绑定手机
//    Route::post('user_m/updatetel', 'h5\View\UserController@updateTel');//绑定手机
//    Route::post('user_m/updateNewTel', 'h5\View\UserController@updateNewTel');//绑定手机
//    Route::get('user_m/settel', 'h5\View\UserController@setTel');//绑定手机
//    Route::get('user_m/bindmail', 'h5\View\UserController@bindmail');//绑定邮箱第一步
//    Route::get('user_m/setmail', 'h5\View\UserController@setMail');//绑定邮箱第二步
//    Route::post('user_m/updateNewEmail', 'h5\View\UserController@updateNewEmail');//更新邮箱
//    Route::get('user_m/address', 'h5\View\UserController@addAddress');//添加收货地址
//    Route::post('user_m/saveaddress', 'h5\View\UserController@saveAddress');//保存收货地址
//    Route::get('user_m/addresslist', 'h5\View\UserController@addresslist');//地址列表
//    Route::get('user_m/confirm/{id}', 'h5\View\UserController@addressOrderConfirm');//确认收货地址
//    Route::post('user_m/confirm', 'h5\View\UserController@orderAddress');//保存收货地址
//    Route::get('user_m/editaddr/{id}', 'h5\View\UserController@editAddress');//编辑地址
//    Route::post('user_m/deleteAddress', 'h5\View\UserController@deleteAddress');//删除地址
//    Route::post('user_m/setdefault', 'h5\View\UserController@setDefault');//设置默认地址
//    Route::get('user_m/recharge_now', 'h5\View\UserController@recharge_now');//充值
//    Route::post('user_m/saveface', 'h5\View\UserController@saveFace');//保存图像
//    Route::post('user_m/saveinfo', 'h5\View\UserController@saveUserInfo');//保存图像
//    Route::get('user_m/userinfo', 'h5\View\UserController@userInfo');//用户中心
//    Route::get('user_m/setinfo', 'h5\View\UserController@setUserInfo');//用户中心
//    Route::get('user_m/setting', 'h5\View\UserController@setting');//我的积分
//    Route::get('user_m/withdraw', 'h5\View\UserController@withdrawCash');//提现到银行卡
//    Route::get('user_m/tomoney', 'h5\View\UserController@commiToMoney');//佣金转余额
//    Route::post('user_m/ajaxtomoney', 'h5\View\UserController@ajaxCommiToMoney');//ajax佣金转余额
//    Route::get('user_m/commitobank', 'h5\View\UserController@commiTobank');//佣金转余额
//    Route::post('user_m/ajaxcommitobank', 'h5\View\UserController@ajaxCommiTobank');//ajax佣金转余额
//    Route::get('user_m/editpwd', 'h5\View\UserController@editpwd');//修改密码
//    Route::get('user_m/account', 'h5\View\UserController@account');//云购详情
//    Route::get('user_m/invite', 'h5\View\UserController@myInvite');//邀友记录
//    Route::get('user_m/invite_ajax', 'h5\View\UserController@myInvite_ajax');//我的账户
//    Route::get('user_m/inviteprize', 'h5\View\UserController@invitePrize');//邀友获奖记录
//    Route::get('user_m/bribery', 'h5\View\UserController@myBriberyMoney');//我的红包
//    Route::get('user_m/mycommission', 'h5\View\UserController@myCommission');//我的红包
//    Route::get('user_m/show', 'h5\View\UserController@showRecord');//我的晒单
//    Route::get('user_m/showorder/{oid}', 'h5\View\UserController@showOrder'); //晒单
//    Route::post('user_m/showpic', 'h5\View\UserController@showPic');//我的晒单保存图片
//    Route::post('user_m/savepics', 'h5\View\UserController@savePics');//我的晒单
//    Route::get('user_m/editshow/{id}', 'h5\View\UserController@editShowOrder');//编辑我的晒单
//    Route::get('user_m/showdetail/{id}', 'h5\View\UserController@showDetail');//晒单详情
//    Route::get('user_m/showlist', 'h5\View\UserController@showlist');//我的已晒单列表
//    Route::get('user_m/buy', 'h5\View\UserController@buyRecord');//我的云购记录
//    Route::get('user_m/buydetail/{id}', 'h5\View\UserController@buyDetail');//云购码详情
//    Route::get('user_m/setnickname', 'h5\View\UserController@setnickname');//我的云购记录
//    Route::get('user_m/usercenter2', 'h5\View\UserController@usercenter2');//用户中心
//    Route::get('user_m/score', 'h5\View\UserController@myScore');//我的积分
//    Route::get('user_m/prize', 'h5\View\UserController@prizeRecord');//我的中奖记录
//    Route::get('user_m/virtualprize/{id}', 'h5\View\UserController@virtualprize');//话费自动充值1
//    Route::post('user_m/autorecharge', 'h5\View\UserController@autoRecharge');//话费自动充值2
//    Route::post('user_m/confirmGood', 'Foreground\View\UserController@confirmGood');//确认收货
//   	Route::get('user_m/help_m', 'h5\View\IndexController@help');//帮助页面
//   	Route::get('user_m/article_m/{id}', 'h5\View\IndexController@article_content');//帮助页面内容
//   	Route::get('user_m/level', 'h5\View\UserController@mylevel');//个人等级，需要移到上面的路由组
//    //用户中心end
//
//    Route::get('mycart_m', 'h5\View\ShoppingController@mycart');//我的购物车
//    Route::get('mycart_m_empty', 'h5\View\ShoppingController@mycart_m_empty');//我的购物车-空购物车
//    Route::post('addCart_m', 'h5\Service\ShoppingController@addCart');//添加购物车
//    Route::post('deleteCart_m', 'h5\Service\ShoppingController@deleteCart');//删除购物车商品
//    Route::post('clearCart_m', 'h5\Service\ShoppingController@clearCart');//清空购物车
//    Route::post('createOrder_m', 'h5\Service\ShoppingController@createOrder');//刷新购物车付款金额
//
//    Route::post('pay_m', 'h5\Service\PayController@pay');//支付页
//    Route::post('refreshPayAmount_m', 'h5\Service\PayController@refreshPayAmount');//ajax刷新支付金额
//    Route::post('paySubmit_m', 'h5\Service\PayController@paySubmit');//提交支付
//    Route::post('chargeSubmit_m', 'h5\Service\ShoppingController@chargeSubmit');//提交支付
//    Route::post('money_m/pay', 'h5\Service\MoneyPayController@pay');//余额支付
//    Route::post('unionpay_m/pay', 'h5\Service\UnionPayController@pay');//银联支付
//    Route::post('alipay_m/pay', 'h5\Service\AlipayController@pay');//支付宝支付
//    Route::post('weixin_m/pay/', 'h5\Service\WxPayController@pay');//微信支付
//    Route::post('weixin_app/pay', 'h5\Service\WxAppPayController@pay');//app微信支付
//
//    Route::get('wx_pay_s', 'h5\Service\WxPayController@wx_pay_s');//我的购物车
//    Route::get('wx_pay_f', 'h5\Service\WxPayController@wx_pay_f');//我的购物车
//
//    //支付后回调页面
//    Route::post('unionpay_m/return','h5\Service\UnionPayController@redirect');
//
//    Route::get('destory_login_m','h5\Service\AuthController@destoryLogin');//注销登陆
//
//	//块乐豆充值页面
//	Route::get('cz','h5\View\UserController@klBeanCharge');
//	Route::post('cz_sub','h5\View\UserController@klBeanChargeSubmit');
//});
//
//Route::group(['middleware' => 'web'], function (){
//	Route::get('index_m', 'h5\View\IndexController@index');//首页
//   	Route::get('makemoney_m_new', 'h5\View\MakeMoneyController@makeMoney');//我要挣钱
//   	Route::get('partner_m', 'h5\View\MakeMoneyController@partner');//我要挣钱
//	Route::get('login_m', 'h5\View\AuthController@login'); //登录
//	Route::get('union_m', 'h5\View\AuthController@union'); //关联账号
//	Route::get('user_m/order_detail/{type?}', 'h5\View\UserController@orderDetail');//订单进度
//	Route::get('find_m', 'h5\View\IndexController@find'); //晒单
//	Route::get('product_m/{id}', 'h5\View\ProductsController@product');//商品详情
//	Route::get('productdetail_m/{id}', 'h5\View\ProductsController@productdetail');//商品详情
//	Route::post('product_m/getbuyrecord','h5\Service\ProductsController@getAllBuyRecord');//获取该商品所有用户的购买信息
//
//	Route::get('calculate_m/{id}', 'h5\View\ProductsController@calculate');//商品详情
//	Route::get('agreement_m', 'h5\View\IndexController@agreement');//服务协议
//
//	Route::get('usercenter', 'h5\View\IndexController@userCenter');//用户中心(未登录)
//
//
//	Route::get('jjjx_m', 'h5\View\IndexController@jjjx');
//	Route::get('category_m', 'h5\View\ProductsController@productCatgory');//商品所有分类
//	Route::get('search_m', 'h5\View\ProductsController@search');//搜索
//    Route::get('search_cookie', 'h5\View\ProductsController@get_history');//搜索
//	Route::get('search_m_result', 'h5\View\ProductsController@search_result');//搜索结果页
//	Route::get('other_m', 'h5\View\IndexController@home');//搜索结果页
//	Route::get('forgetpwd_m', 'h5\View\IndexController@forgetpwd');//找回密码
//	Route::get('product_content_m', 'h5\View\IndexController@product_content');
//	Route::get('wqjx_m', 'h5\View\IndexController@wqjx');//往期揭晓
//	Route::get('selectperiods_m', 'h5\View\ProductsController@selectperiods');//期数查询
//	Route::get('geturlbyperiod', 'h5\View\ProductsController@getUrlByPeriod');//获取期数对应的url
//	Route::get('advise_m', 'h5\View\IndexController@advise');//建议反馈
//
//	Route::get('guide_m', 'h5\View\IndexController@guide');//引导页
//	Route::get('jiexiao_m', 'h5\View\IndexController@announcement');//正在揭晓的商品列表
//	Route::get('getlotteryafter', 'h5\View\IndexController@getLotteryAfter');//正在揭晓的商品列表
//	Route::get('reg_m', 'h5\View\AuthController@register');//注册页面
//	Route::post('register_m', 'h5\Service\AuthController@register');//注册页面
//	Route::post('regSubmit_m', 'h5\Service\AuthController@regSubmit_m');//注册页面
//
//	Route::get('freeday_m', 'h5\View\FreeDayController@index');//天天免费
//    Route::get('cookie', 'h5\View\FreeDayController@index');//天天免费
//
//    Route::get('share_m', 'h5\View\ShareController@index'); //晒单广场
//    Route::get('sharePlus', 'h5\View\ShareController@sharePlus'); //晒单广场
//    Route::get('sharedetail_m/{id}', 'h5\View\ShareController@sharedetail'); //晒单详情
//    Route::post('share_m/pushcomment', 'h5\View\ShareController@pushComment');  //晒单点赞
//
//    Route::post('user_m/login', 'h5\Service\AuthController@login');//登陆
//    Route::post('user_m/setpwd', 'h5\View\UserController@setpwd');//设置密码
//    Route::post('user_m/resetpwd', 'h5\View\UserController@resetpwd');//重置密码
//    Route::post('checkVerifyCode_m', 'h5\Service\AuthController@checkVerifyCode');
//    Route::get('him_m/getHisBuy/{uid}', 'h5\View\IndexController@getHisBuy');//他人购买记录
//    Route::any('him_m/getFetchnoInfo', 'h5\View\IndexController@getFetchnoInfo');//中奖订单信息
//    Route::any('him_m/getajxaHisBuy', 'h5\View\IndexController@getajxaHisBuy');//中奖订单信息
//    Route::get('him_m/getHisBuy2', 'h5\View\HimController@getHisBuy');//他人购买记录
//    Route::post('regverify_m', 'h5\Service\AuthController@sendSmsCode');  //注册验证码
//    Route::post('mobileSendCode_m', 'h5\Service\AuthController@mobileSendCode');  //第三方绑定 发送验证码  16.6.28 by baoyaoling
//    Route::post('bindUser_m', 'h5\Service\AuthController@bindUser');  //第三方绑定 发送验证码  16.6.28 by baoyaoling
//    Route::post('regverify_m_set', 'h5\Service\AuthController@sendSmsCodeForget');  //注册验证码
//    Route::get('captcha_m/{tmp}', 'h5\View\AuthController@captcha');
//
//    Route::get('wxcallback_m', 'h5\Service\AuthController@wxCallBack');//微信登陆回调接口 16.6.14 by  baoyaoling
//    Route::get('qqcallback_m', 'h5\Service\AuthController@qqCallBack');//qq登陆回调接口 16.6.16 by  baoyaoling
//    //银联支付回调
//    Route::post('unionpay_m/result', 'h5\Service\UnionPayController@result');
//
//    Route::get('pay_fail', 'h5\Service\MoneyPayController@pay_fail');
//
//    Route::get('oauth', 'OauthController@index');
//});


//带登陆验证中间件过滤路由组
Route::group(['middleware' =>'web_with_login'], function () {

    /**购物车 route start*******/
    Route::get('mycart', 'Foreground\View\ShoppingController@mycart');//我的购物车
    Route::post('addCart', 'Foreground\Service\ShoppingController@addCart');//添加购物车
    Route::post('updateCart', 'Foreground\Service\ShoppingController@updateCart');//更新购物车
    Route::post('deleteCart', 'Foreground\Service\ShoppingController@deleteCart');//删除购物车商品
    Route::post('clearCart', 'Foreground\Service\ShoppingController@clearCart');//清空购物车
    Route::post('refreshPayAmount', 'Foreground\Service\ShoppingController@refreshPayAmount');//刷新购物车付款金额
    Route::post('orderSubmit', 'Foreground\Service\ShoppingController@orderSubmit');//刷新购物车付款金额
    Route::post('updateChoose', 'Foreground\Service\ShoppingController@updateChoose');//选中及取消选中购物车商品
    /**购物车 end***/

    /**支付start**/
    //微信支付
    Route::post('weixin/pay', 'Foreground\Service\WxPayController@index');
    Route::post('weixin/check', 'Foreground\Service\WxPayController@checkOrder');
    Route::get('weixin/result', 'Foreground\Service\WxPayController@wxResult');

    //银联支付处理
    Route::post('unionpay/pay','Foreground\Service\UnionPayController@pay');
    //支付后回调页面
    Route::post('unionpay/return','Foreground\Service\UnionPayController@redirect');

    //余额支付
    Route::post('money/pay', 'Foreground\Service\MoneyPayController@index');

	//京东网关支付
	Route::post('jdpay/pay', 'Foreground\Service\JdPayController@index');
	//支付后回调页面
	Route::post('jdpay/redirect','Foreground\Service\JdPayController@redirect');
    /**支付end**/

    Route::get('user', 'Foreground\View\UserController@index');//会员
    Route::get('user/account', 'Foreground\View\UserController@index');//我的账户
    Route::post('user/confirmGood', 'Foreground\View\UserController@confirmGood');//确认收货
    Route::post('user/levelup', 'Foreground\View\UserController@levelUp');//用户升级
    Route::get('user/recharge/{type?}', 'Foreground\View\UserController@rechargeRecord');//充值记录
	Route::get('user/recharge_now', 'Foreground\View\UserController@recharge_now');//正在充值
    Route::get('user/buy/{type?}', 'Foreground\View\UserController@buyRecord');//我的夺宝记录
    Route::post('user/ajaxObtainOrderInfo', 'Foreground\View\UserController@ajaxObtainOrderInfo');//我的夺宝记录
    Route::get('user/prize/{type?}', 'Foreground\View\UserController@prizeRecord');//我的账户
    Route::get('user/testRecharge', 'Foreground\View\UserController@testRecharge');//我的账户
    Route::post('user/autorecharge', 'Foreground\View\UserController@autoRecharge');//我的账户
    Route::get('user/inviteprize', 'Foreground\View\UserController@invitePrize');//邀友获奖记录
    Route::any('user/orderAddres', 'Foreground\View\UserController@orderAddres');//我的账户
    Route::get('user/show', 'Foreground\View\UserController@showRecord');//我的晒单
    Route::post('user/showdetail', 'Foreground\View\UserController@showDetail');//晒单详情
    Route::post('user/editshow', 'Foreground\View\UserController@editShow');//晒单详情
 
    Route::post('user/saveShowInfo', 'Foreground\View\UserController@saveShowInfo');//进行晒单信息保存
    Route::get('user/score/{status?}/{type?}', 'Foreground\View\UserController@myScore');//我的积分
    Route::get('user/bribery/{state?}/{type?}', 'Foreground\View\UserController@myBriberyMoney');//我的红包
    Route::get('user/invite', 'Foreground\View\UserController@myInvite');//我的账户
    Route::get('user/invite/score', 'Foreground\View\UserController@myInviteScore');//我的账户
    Route::get('user/commission', 'Foreground\View\UserController@myCommission');//我的账户 - 我的佣金，招募合伙人
    Route::get('user/commissionsource', 'Foreground\View\UserController@myCommissionsource');//我的账户 - 佣金来源
    Route::get('user/commissionbuy', 'Foreground\View\UserController@commissionbuy');//我的账户 - 佣金消费
    Route::post('user/commitomoney', 'Foreground\View\UserController@commiToMoney');//我的账户 -佣金转余额
    Route::post('user/commitobank', 'Foreground\View\UserController@commiTobank');//我的账户 -佣金转余额
    Route::get('user/mybankcard', 'Foreground\View\UserController@mybankcard');//我的账户 - 我的银行卡
    Route::get('user/addbankcard', 'Foreground\View\UserController@addbankcard');//我的账户 - 添加新银行卡
    Route::post('user/savebank', 'Foreground\View\UserController@saveBank');//我的账户 - 添加新银行卡
    Route::get('user/editbank/{id}', 'Foreground\View\UserController@editBank');//我的账户 - 修改银行卡
    Route::post('user/delbank', 'Foreground\View\UserController@delBank');//我的账户 -删除银行卡
    Route::get('user/withdraw', 'Foreground\View\UserController@withdrawCash');//我的账户 -删除银行卡
    Route::get('user/address/{address?}', 'Foreground\View\UserController@myAddress');//我的账户 - 收货地址
    Route::post('user/orderAddress', 'Foreground\View\UserController@orderAddress');//我的账户 - 收货地址
    Route::post('user/address/submit', 'Foreground\View\UserController@saveAddress');//我的账户 - 收货地址
    Route::any('user/deleteAddress', 'Foreground\View\UserController@deleteAddress');//我的账户 - 删除收货地址
    Route::post('user/saveuserpic', 'Foreground\View\UserController@saveUserPic');//我的账户 - 修改头像
    Route::get('user/security', 'Foreground\View\UserController@securityCenter');//我的账户 - 安全中心
    Route::post('user/security/updateNickname', 'Foreground\View\UserController@updateNickname');//我的账户 - 修改昵称
    Route::post('user/wx_unbind', 'Foreground\View\UserController@wxUnbind');//微信解绑 16.6.14 by byl
    Route::post('user/qq_unbind', 'Foreground\View\UserController@qqUnbind');//qq解绑 16.6.16 by byl
    Route::any('user/security/getUserByjava', 'Foreground\View\UserController@getUserByjava');//我的账户 - 获取用户信息
    Route::any('user/security/updatePassWord', 'Foreground\View\UserController@updatePassWord');//我的账户 - 修改密码
    Route::any('user/security/getSmsCode', 'Foreground\View\UserController@getSmsCode');//我的账户 - 获取短信验证码
    Route::post('user/security/submitSmsCode', 'Foreground\View\UserController@submitSmsCode');//我的账户 - 验证验证码正确性
    Route::post('user/security/getSmsCodeNewPhone', 'Foreground\View\UserController@getSmsCodeNewPhone');//我的账户 - 获取短信验证码新手机绑定
    Route::post('user/security/submitSmsCodeNewPhone', 'Foreground\View\UserController@submitSmsCodeNewPhone');//我的账户 - 验证验证码正确性新手机
    Route::any('user/security/updateUserPhone', 'Foreground\View\UserController@updateUserPhone');//我的账户 - 修改绑定手机
    Route::any('user/security/updateUserEmail', 'Foreground\View\UserController@updateUserEmail');//我的账户 - 修改绑定邮箱
    Route::any('user/security/sendEmail', 'Foreground\View\UserController@sendEmail');//我的账户 - 修改绑定邮箱
    Route::any('user/security/getUserPhoto', 'Foreground\View\UserController@getUserPhoto');//我的账户 - 头像获取
    Route::get('/user/message', 'Foreground\View\UserController@sysMessage');//系统消息
    Route::post('/user/setmessage', 'Foreground\View\UserController@setMessage');//设置消息已读

    Route::any('user/security/phoneSendCode', 'Foreground\View\UserController@phoneSendCode');//我的账户 - 测试

    Route::get('user/unpay', 'Foreground\View\UserController@myUnpayOrder');//我的账户 - 修改绑定邮箱


    Route::get('user/question', 'Foreground\View\UserController@FAQ');//我的账户 - 常见问题
    Route::get('user/pic', 'Foreground\View\UserController@pic');//我的账户 - 常见问题

    Route::post('freeday/getNum', 'Foreground\Service\FreeDayController@getNum');//天天免费
    Route::post('freeday/checkBean', 'Foreground\Service\FreeDayController@checkBean');//天天免费
    Route::post('freeday/inviteExchange', 'Foreground\Service\FreeDayController@inviteExchange');//天天免费

    Route::post('share/pushcomment', 'Foreground\View\ShareController@pushComment');//活动发现


    Route::get('/synchronize','Foreground\Service\AuthController@synchronize');//ajax轮询登录


	Route::post('rotary/run_t', 'Foreground\Service\RotaryController@run');//大转盘抽奖
	Route::post('rotary/run_o', 'Foreground\Service\RotaryController@runFree');//大转盘抽奖（免费）
	Route::post('rotary/upstatus', 'Foreground\Service\RotaryController@updateStatus');  //大转盘更新中奖状态

});


//基础中间件过滤路由组
Route::group(['middleware' => 'web'], function () {
//     Route::auth();
    //后台系统路由
    Route::group(['prefix'=>'backend', 'middleware' => 'auth'], function() {

        /**栏目管理路由start**/
        Route::get('shop/category', 'Backend\ShopController@category');
		Route::get('shop/upCategory/{id}', 'Backend\ShopController@upCategory');
		Route::post('shop/dealUpCategory', 'Backend\ShopController@dealUpCategory');
		Route::post('shop/delCategory', 'Backend\ShopController@delCategory');
		Route::get('shop/category', 'Backend\ShopController@category');
		Route::get('shop/addCategory/{id}', 'Backend\ShopController@addCategory');
		Route::post('shop/saveCategory', 'Backend\ShopController@saveCategory');
		/**栏目管理路由end**/

		/**品牌路由 start***/
		Route::get('shop/brand', 'Backend\ShopController@brand');
		Route::get('shop/addBrand', 'Backend\ShopController@addBrand');
		Route::post('shop/saveBrand', 'Backend\ShopController@saveBrand');
		Route::post('shop/delBrand/', 'Backend\ShopController@delBrand');
		Route::get('shop/upBrand/{id}', 'Backend\ShopController@upBrand');
		Route::post('shop/dealUpBrand/', 'Backend\ShopController@dealUpBrand');
		Route::any('shop/getBrandid', 'Backend\ShopController@getBrandid');
		/**品牌路由 end***/

		/**商品管理 route start*******/

		Route::get('shop/lookShop/{id}', 'Backend\ShopController@lookShop');
		Route::get('shop/addShop', 'Backend\ShopController@addShop');
		Route::post('shop/delShop/', 'Backend\ShopController@delShop');
		Route::post('shop/delShopPic', 'Backend\ShopController@delShopPic');
		Route::get('shop/upShop/{id}', 'Backend\ShopController@upShop');
		Route::post('shop/dealUpShop', 'Backend\ShopController@dealUpShop');
		Route::get('shop/loadUoloadShopAgain/{id}', 'Backend\ShopController@loadUoloadShopAgain');
		Route::post('shop/uploadShopAgain', 'Backend\ShopController@uploadShopAgain');
		Route::any('shop/saveShop', 'Backend\ShopController@saveShop');
		Route::any('shop/savePic', 'Backend\ShopController@savePic');
		Route::get('shop/activityList', 'Backend\ShopController@activityList');
		Route::get('shop/addActivityShop', 'Backend\ShopController@addActivityShop');
		Route::get('shop/searchShop/{keyword}', 'Backend\ShopController@searchShop');
		Route::post('shop/saveActivityShop', 'Backend\ShopController@saveActivityShop');
		Route::post('shop/setStatus', 'Backend\ShopController@setStatus');
		Route::get('shop/exportShop', 'Backend\ShopController@exportShop');//商品导表
		Route::get('shop/merchants', 'Backend\ShopController@merchants');//商户列表
		Route::any('shop/addMerchants', 'Backend\ShopController@addMerchants');//添加商户列表
		Route::any('shop/delMerchants', 'Backend\ShopController@delMerchants');//删除
		Route::post('shop/changeMerchants', 'Backend\ShopController@changeMerchants');//编辑

		Route::resource('shop', 'Backend\ShopController');
        /**商品管理 route end********/
        
      
       
		
        /**红包管理 route start*******/
        Route::get('redbao/getList', 'Backend\RedbaoController@getList');
		Route::get('redbao/addRedbao', 'Backend\RedbaoController@addRedBao');
		Route::post('redbao/saveRedBao', 'Backend\RedbaoController@saveRedBao');
		Route::post('redbao/delRedBao', 'Backend\RedbaoController@delRedBao');
		Route::get('redbao/upRedbao/{id}', 'Backend\RedbaoController@upRedbao');
		Route::post('redbao/delUpdateRedBao', 'Backend\RedbaoController@delUpdateRedBao');
		Route::any('redbao/gift', 'Backend\RedbaoController@gift');

		/**红包管理 route end********/

		/**界面管理 route start*******/
		Route::resource('navigation', 'Backend\NavigationController');  //导航条管理
		Route::post('rotation/savePic', 'Backend\RotationController@savePic');  //轮播图上传
		Route::get('rotation/editRo/{id}', 'Backend\RotationController@editRo');  //加载更新页
		Route::get('rotation', 'Backend\RotationController@index');  //轮播图列表
		Route::get('rotation/deleteRo/{id}', 'Backend\RotationController@deleteRo');  //删除
		Route::post('rotation/updateRo', 'Backend\RotationController@updateRo');  //更新
		Route::post('rotation/setorder', 'Backend\RotationController@setOrder');  //轮播图设置显示顺序
		Route::post('rotation/setshow', 'Backend\RotationController@setShow');  //轮播图设置
		Route::resource('rotation', 'Backend\RotationController');  //轮播图管理
		/**界面管理 route end ********/

        Route::resource('home', 'Backend\HomeController');
        Route::resource('admin', 'Backend\AdminController');
        Route::get('article', 'Backend\ArticleController@index');//显示所有文章分类
        Route::get('article/addarticlecat', 'Backend\ArticleController@addArticleCat');//添加文章分类
        Route::post('article/storearticlecat', 'Backend\ArticleController@storeArticleCat');//保存文章分类
        Route::post('article/delarticlecat', 'Backend\ArticleController@delArticleCat');//删除文章分类
        Route::get('article/showarticles', 'Backend\ArticleController@showArticles');//显示所有文章
        Route::get('article/addarticle', 'Backend\ArticleController@addArticle');//添加文章
        Route::post('article/storearticle', 'Backend\ArticleController@storeArticle');//保存文章
        Route::get('article/editarticle/{id}', 'Backend\ArticleController@editArticle');//编辑文章
        Route::post('article/delarticle', 'Backend\ArticleController@delArticle');//删除文章
        Route::get('article/editarticlecat/{id}', 'Backend\ArticleController@editArticleCat');//文章分类编辑
        Route::get('member/loginRecord', 'Backend\MemberController@loginRecord');//用户登录信息
        Route::any('member/SerachLoginRecord', 'Backend\MemberController@SerachLoginRecord');//用户登录信息
        Route::get('member/exportUserLogin', 'Backend\MemberController@exportUserLogin');//用户信息导表
        Route::post('member/uplevel', 'Backend\MemberController@upLevel');//用户升级为渠道用户
        Route::get('member/showorder', 'Backend\MemberController@showOrder');//显示所有晒单记录
        Route::post('member/setShoworderSort', 'Backend\MemberController@setShoworderSort');//设置晒单排序
        Route::post('member/checkshoworder', 'Backend\MemberController@checkShowOrder');//审核晒单
        Route::post('member/refused', 'Backend\MemberController@refused');//提交晒单审核不通过原因
        Route::post('member/setFengHao', 'Backend\MemberController@setFengHao');//提交晒单审核不通过原因
        Route::get('member/showorderdetail/{id}/{sd_gid}', 'Backend\MemberController@showOrderDetail');//晒单详情
        Route::any('member/muchPhoneSearch', 'Backend\MemberController@muchPhoneSearch');//手机批量搜索
        Route::get('member/exportUser', 'Backend\MemberController@exportUser');//用户信息导表



        Route::get('member/friendlink', 'Backend\MemberController@showFriendlink');//友情链接
        Route::get('member/addfriendlink', 'Backend\MemberController@addFriendlink');//添加友情链接
        Route::get('member/editfriendlink/{id}', 'Backend\MemberController@editFriendlink');//编辑友情链接
        Route::post('member/savefriendlink', 'Backend\MemberController@saveFriendlink');//保存友情链接
        Route::post('member/delfriendlink', 'Backend\MemberController@delFriendlink');//删除友情链接
        Route::get('member/cleanLinkCache', 'Backend\MemberController@cleanLinkCache');//清除友情链接缓存
		
        Route::post('member/unsafeuse/markunsafe', 'Backend\MemberController@markAllUnsafe');//标记所有好友为异常 16.6.20 by byl
        Route::get('member/unsafeuse/{username?}', 'Backend\MemberController@unsafeUser');//异常用户管理 16.6.20 by byl
        Route::get('member/{username?}', 'Backend\MemberController@index');//用户显示
        Route::any('order', 'Backend\OrderController@index');//订单管理
        Route::any('order/getprize', 'Backend\OrderController@getprizeorder');//领取奖励的订单
        Route::post('order/cheackorder', 'Backend\OrderController@cheackOrder');//订单审查
		Route::post('order/takeorder', 'Backend\OrderController@takeOrder');//自提订单
		Route::any('order/takeorderpl', 'Backend\OrderController@takeOrderpl');//批量自提订单
        Route::get('order/orderlook/{id}', 'Backend\OrderController@orderLook');//订单详情
        Route::get('order/orderdayin/{id}', 'Backend\OrderController@orderdayin');//订单打印
        Route::post('order/setDayinId', 'Backend\OrderController@setDayinId');//设置批量打印的session条件
        Route::get('order/orderdayinpl', 'Backend\OrderController@orderdayinpl');//订单打印
        Route::get('order/orderdayinp/{id}', 'Backend\OrderController@orderdayinp');//活动打印
        Route::post('order/unsetSearch', 'Backend\OrderController@unsetSearch');//重置搜索条件
        Route::get('order/daoBiao', 'Backend\OrderController@daoBiao');//导表
        Route::any('order/sendGood', 'Backend\OrderController@sendGood');//发货
        Route::get('bank', 'Backend\MemberController@withdrawCash');//佣金提现
        Route::post('bank/checkpass', 'Backend\MemberController@checkPass');//打款
        Route::post('bank/checkrefuse', 'Backend\MemberController@checkRefuse');//拒绝打款
		Route::resource('lottery', 'Backend\LotteryController');


		//含抵扣订单
		Route::any('order/ordernew', 'Backend\OrdernewController@index');//订单详情
		Route::any('order/unsetSearchOrdernew', 'Backend\OrdernewController@unsetSearchOrdernew');//重置搜索条件
		Route::get('order/daoBiaonew', 'Backend\OrdernewController@daoBiaonew');//导表
		//推广渠道管理
		Route::get('promote', 'Backend\PromoteController@index');//充值卡状态列表
		Route::any('promote/bangka', 'Backend\PromoteController@bangka');//充值卡新式绑法
		Route::post('promote/search', 'Backend\PromoteController@search');//充值卡查询
		Route::get('promote/userIndex', 'Backend\PromoteController@userIndex');//推广员列表
		Route::get('promote/searchUser/{mobile}', 'Backend\PromoteController@searchUser');//推广员查询
		Route::get('promote/addUser', 'Backend\PromoteController@addUser');//推广员新增
		Route::post('promote/plUpdata', 'Backend\PromoteController@plUpdata');//批量操作解冻、冻结
		Route::get('promote/upIsJiedong','Backend\PromoteController@upIsJiedong');//单个操作解冻、冻结
		Route::get('promote/addUserCardNum','Backend\PromoteController@addUserCardNum');//添加卡数
		Route::get('promote/testUser','Backend\PromoteController@testUser');//检测用户是否添加了
		Route::any('promote/getOfflineInfo/{mobile?}','Backend\PromoteController@getOfflineInfo');//检测用户是否添加了
		Route::post('promote/searchNum','Backend\PromoteController@searchNum');//检测卡号区间情况
		Route::post('promote/noBindRecommendid','Backend\PromoteController@noBindRecommendid');//卡号区间批量解绑
		Route::post('promote/submitBind','Backend\PromoteController@submitBind');//卡号区间批量绑定
		
		
		//财务对账
		Route::get('finance/chage', 'Backend\FinanceController@chage');//充值记录
		Route::get('finance/buy', 'Backend\FinanceController@buy');//消费记录
		Route::get('finance/lottery', 'Backend\FinanceController@lottery');//中奖记录
		Route::any('finance/search', 'Backend\FinanceController@search');//搜索记录
		Route::any('finance/export', 'Backend\FinanceController@export');//财务导表
		Route::any('finance/tongji', 'Backend\FinanceController@tongji');//数据统计
		Route::any('finance/redBadBuyShop', 'Backend\FinanceController@redBadBuyShop');//抵扣汇总
		Route::get('finance/bigWheelIfno', 'Backend\FinanceController@bigWheelIfno');//转盘红包明细
		Route::any('finance/bigWheelInfoSearch', 'Backend\FinanceController@bigWheelInfoSearch');//转盘红包明细
		Route::get('finance/exportBigWheel', 'Backend\FinanceController@exportBigWheel');//转盘红包导表
		
        //话费充值管理
		Route::get('huafei/recharge', 'Backend\HuafeiController@index');//中奖话费充值列表
		//商品数据导入
		//Route::get('goodsImport', 'Backend\ImportController@index');
        //系统消息  16.7.5 by byl
        Route::any('sys/msg', 'Backend\MessageController@index');//消息列表
        Route::any('sym/msgedit', 'Backend\MessageController@msgEdit');//消息推送
        Route::post('sym/excelImport', 'Backend\MessageController@excelImport');//消息推送
        //end

	    //大转盘
	    Route::get('rotary', 'Backend\RotaryController@index');//大转盘
	    Route::get('rotary/edit/{id}', 'Backend\RotaryController@edit');//编辑奖品
	    Route::post('rotary/save', 'Backend\RotaryController@save');//编辑奖品
		
		//管理员系统项
		Route::get('manager/creatH5ProHtml', 'Backend\HomeController@creatH5ProHtml');//编辑奖品
    });

    //后台登陆注册路由
    Route::controllers([
            'auth' => 'Auth\AuthController',
            'password' => 'Auth\PasswordController',
    ]);

    //前台路由
    if(strpos($_SERVER['SERVER_NAME'], 'm.ts1kg.com') !== false){
        Route::get('/', 'h5\View\IndexController@index');//首页
    }else{
        Route::resource('/', 'Foreground\View\IndexController');//默认首页
    }

    Route::get('index', 'Foreground\View\IndexController@index');//首页
    Route::get('guide','Foreground\View\IndexController@guide');//新手指南页面
    Route::post('jiujiu/recharge','Foreground\View\IndexController@recharge');//99自动充值回调接口
    Route::get('announcement','Foreground\View\IndexController@announcement');//最新揭晓页面
    Route::get('customer', 'Foreground\View\IndexController@customer');//客服页面
    Route::get('help/{id}', 'Foreground\View\IndexController@help');//帮助页面
    Route::get('link', 'Foreground\View\IndexController@friendLink');//友情链接
    Route::get('notice/{id}', 'Foreground\View\IndexController@noticeBoard');//公告
    Route::get('getLatestRecord', 'Foreground\View\IndexController@getLatestRecord');//获取最新一百条购买记录
    Route::get('getHistoryRecord', 'Foreground\View\IndexController@getHistoryRecord');//获取历史购买记录
    Route::any('searchRecord', 'Foreground\View\IndexController@searchRecord');//查询历史购买记录
    Route::get('search/{type?}/{p?}', 'Foreground\View\ProductsController@search');//搜索页
    Route::get('app', 'Foreground\View\IndexController@app');//APP下载页

    Route::get('login', 'Foreground\View\AuthController@login');
    Route::get('register', 'Foreground\View\AuthController@register');
 //   Route::get('binduser', 'Foreground\View\AuthController@binduser');
    Route::get('register_for_test', 'Foreground\View\AuthController@register_for_test');//测试注册接口

    Route::post('checkMobileExist', 'Foreground\Service\AuthController@checkMobileExist');

    Route::get('forgetpwd', 'Foreground\View\AuthController@forgetpwd');
    Route::get('captcha/{tmp}', 'Foreground\View\AuthController@captcha');
    Route::post('checkCaptcha', 'Foreground\Service\AuthController@checkCaptcha');
    Route::post('checkVerifyCode', 'Foreground\Service\AuthController@checkVerifyCode');
    Route::post('setPass', 'Foreground\Service\AuthController@setPass');

    Route::get('destory_login','Foreground\Service\AuthController@destoryLogin');//注销登陆

    Route::get('product/{id}', 'Foreground\View\ProductsController@product');//商品详情
    Route::get('prod/{id}', 'Foreground\View\ProductsController@proCurObj');
	
	
    Route::get('category/{cateid?}', 'Foreground\View\ProductsController@productCatgory');//商品所有分类

    
//    Route::get('freeday', 'Foreground\View\FreeDayController@index');//天天免费
	Route::get('freeday', 'Foreground\View\RotaryController@index');//大转盘

    Route::get('makeMoney', 'Foreground\View\MakeMoneyController@makeMoney');//我要赚钱

	//他人主页
	Route::get('him/{usrid}', 'Foreground\View\HimController@index');//他人首页
	Route::get('him/prize/{usrid}', 'Foreground\View\HimController@prizeRecord');//中奖记录
	Route::get('him/buy/{usrid}', 'Foreground\View\HimController@buyRecord');//购买记录
	Route::get('him/show/{usrid}', 'Foreground\View\HimController@show');//晒单列表
    /**ajax 分解首页**/
    Route::get('index/getlatest','Foreground\Service\IndexController@getLatest');
    Route::get('index/getlatest_m','Foreground\Service\IndexController@getLatest_m');
	Route::get('index/checklatest','Foreground\Service\IndexController@checkLatest');//获取最新揭晓商品
    Route::get('index/checklatest_m','Foreground\Service\IndexController@checkLatest_m');//获取最新揭晓商品（h5）
    Route::get('index/getLotteryResult','Foreground\Service\IndexController@getLotteryResult');//获取开奖结果
    Route::get('index/getsoon','Foreground\Service\IndexController@getSoon');//获取热门商品
    Route::get('index/getisbuy','Foreground\Service\IndexController@getIsbuy');//获取正在购买用户
    Route::get('index/getall','Foreground\Service\IndexController@getAll');//获取所有商品
    Route::get('index/getnew','Foreground\Service\IndexController@getNew');//获取新品上架
    Route::get('index/getshow','Foreground\Service\IndexController@getShow');//获取晒单分享
    Route::get('index/getfooter','Foreground\Service\IndexController@getFooter');//获取底部导航
    Route::get('index/getnavigata','Foreground\Service\IndexController@getNavigata');//获取全部商品导航
    Route::get('index/getarticles','Foreground\Service\IndexController@getArticles');//获取文章
    Route::get('product/getbuyrecord/{id}','Foreground\Service\ProductsController@getAllBuyRecord');//获取该商品所有用户的购买信息
    Route::get('product/getshoworder/{id}','Foreground\Service\ProductsController@getShowOrders');//获取该商品的晒单信息
    Route::get('index/getheader','Foreground\Service\IndexController@getAllNavigata');//获取所有导航

    /**ajax 查询信息操作**/
    Route::get('product/checkstatus/{id}','Foreground\Service\ProductsController@getGoodsStatus');//获取商品是否已经开奖


    Route::get('activity', 'Foreground\View\ActivityController@index');//活动发现
    Route::get('news/{id}', 'Foreground\View\ActivityController@newsDetail');//新闻
    Route::get('newslist', 'Foreground\View\ActivityController@newsList');//新闻列表
    Route::post('activity/sendMessage', 'Foreground\Service\ActivityController@sendMessage');//活动发现-发送短信
    Route::post('activity/sendPayMessage', 'Foreground\Service\ActivityController@paySms');//活动发现-收费发送短信
    Route::get('activity/search', 'Foreground\Service\ActivityController@search');//活动发现-收费发送短信

    Route::post('category/postdata','Foreground\Service\ProductsController@postData');//获取商品分类页面所有信息
    Route::post('register', 'Foreground\Service\AuthController@register');
    Route::post('binduser', 'Foreground\Service\AuthController@bindUser');//第三方绑定 有账户的 by byl
    Route::post('bindnouser', 'Foreground\Service\AuthController@bindNoUser');//第三方绑定 无账户 by byl
    Route::post('mobileSendCode', 'Foreground\Service\AuthController@mobileSendCode');//第三方绑定 有账户的 by byl
    Route::get('wxcallback', 'Foreground\Service\AuthController@wxCallBack');//微信登陆回调接口 by  baoyaoling
    Route::get('centercallback', 'Foreground\Service\AuthController@wxCenterCallBack');//用户中心绑定微信回调接口 16.6.16  by  baoyaoling
    Route::get('centerqqcallback', 'Foreground\Service\AuthController@qqCenterCallBack');//用户中心绑定qq回调接口 16.6.16 by  baoyaoling
    Route::get('qqcallback', 'Foreground\Service\AuthController@qqCallBack');//qq登陆回调接口 by  baoyaoling
    Route::post('login', 'Foreground\Service\AuthController@login');
    Route::post('checkMobileExist', 'Foreground\Service\AuthController@checkMobileExist');
    Route::post('upload', 'Foreground\Service\AuthController@checkMobileExist');


    Route::get('share', 'Foreground\View\ShareController@index');//晒单分享
    Route::get('sharedetail/{id}', 'Foreground\View\ShareController@sharedetail');//具体某个晒单详情
    Route::post('user/getFund', 'Foreground\View\UserController@getFund');//我的账户 - 计算公益基金


	Route::post('uploadify/up','Foreground\Service\UploadifyController@up'); //上传组件
	Route::post('uploadify/saveShowPic', 'Foreground\Service\UploadifyController@saveShowPic');//上传晒单图片
	Route::post('uploadify/xuanZhuanPic', 'Foreground\Service\UploadifyController@xuanZhuanPic');//晒单旋转图片处理
	
	

	/**支付回调start**/
	//微信支付回调
	Route::post('weixin/notify', 'Foreground\Service\WxPayController@notify');
	//银联支付回调
	Route::post('unionpay/result', 'Foreground\Service\UnionPayController@result');
	//京东网关支付回调
	Route::post('jdpay/notify', 'Foreground\Service\JdPayController@notify');
	/**支付回调end**/

	Route::post('regverify', 'Foreground\Service\AuthController@sendSmsCode');  //注册验证码
	Route::post('regverify_set', 'Foreground\Service\AuthController@sendSmsCodeForget');  //注册验证码

	//百度验证
	Route::get('baidu_verify_08iIjFIZKm.html', function(){return view('baidu_verify_08iIjFIZKm');});

	//sitemap
	Route::get('sitemap.xml', function(){return view('sitemap');});

	//获取服务器时间
	Route::get('getsystime', 'Foreground\View\IndexController@getSysTime');

	/*API接口*/
	Route::get('getCpsResult', 'api\CpsController@getCpsResult');
	Route::get('xiaoneng', 'api\XiaonengController@getGoodsInfo');

	//Route::get('klcharge_import', 'Foreground\View\KlChargeController@index');
});



/*------------------------------------------------------------------------------------------*/
/*---------------------------------H5路由开始-----------------------------------------------*/
/*------------------------------------------------------------------------------------------*/
Route::group(['middleware' =>'web_with_login_m'], function () {
    //用户中心
    Route::get('user_m/security', 'h5\View\UserController@securityCenter');//安全设置
    Route::get('user_m/updatepwd', 'h5\View\UserController@updatePwd');//安全中心修改密码
    Route::post('user_m/updatepwd', 'h5\View\UserController@updatePassWord');//安全中心修改密码
    Route::get('user_m/123', 'h5\View\UserController@getUserByjava');//安全中心修改密码
    Route::get('user_m/bindtel', 'h5\View\UserController@bindtel');//绑定手机
    Route::post('user_m/sendcode', 'h5\View\UserController@sendCode');//绑定手机
    Route::post('user_m/updatetel', 'h5\View\UserController@updateTel');//绑定手机
    Route::post('user_m/updateNewTel', 'h5\View\UserController@updateNewTel');//绑定手机
    Route::get('user_m/settel', 'h5\View\UserController@setTel');//绑定手机
    Route::get('user_m/bindmail', 'h5\View\UserController@bindmail');//绑定邮箱第一步
    Route::get('user_m/setmail', 'h5\View\UserController@setMail');//绑定邮箱第二步
    Route::post('user_m/updateNewEmail', 'h5\View\UserController@updateNewEmail');//更新邮箱
    Route::get('user_m/address', 'h5\View\UserController@addAddress');//添加收货地址
    Route::post('user_m/saveaddress', 'h5\View\UserController@saveAddress');//保存收货地址
    Route::get('user_m/addresslist', 'h5\View\UserController@addresslist');//地址列表
    Route::get('user_m/confirm/{id}', 'h5\View\UserController@addressOrderConfirm');//确认收货地址
    Route::post('user_m/confirm', 'h5\View\UserController@orderAddress');//保存收货地址
    Route::get('user_m/editaddr/{id}', 'h5\View\UserController@editAddress');//编辑地址
    Route::post('user_m/deleteAddress', 'h5\View\UserController@deleteAddress');//删除地址
    Route::post('user_m/setdefault', 'h5\View\UserController@setDefault');//设置默认地址
    Route::get('user_m/recharge_now', 'h5\View\UserController@recharge_now');//充值
    Route::post('user_m/saveface', 'h5\View\UserController@saveFace');//保存图像
    Route::post('user_m/saveinfo', 'h5\View\UserController@saveUserInfo');//保存图像
    Route::get('user_m/userinfo', 'h5\View\UserController@userInfo');//用户中心
    Route::get('user_m/setinfo', 'h5\View\UserController@setUserInfo');//用户中心
    Route::get('user_m/setting', 'h5\View\UserController@setting');//我的积分
    Route::get('user_m/withdraw', 'h5\View\UserController@withdrawCash');//提现到银行卡
    Route::get('user_m/tomoney', 'h5\View\UserController@commiToMoney');//佣金转余额
    Route::post('user_m/ajaxtomoney', 'h5\View\UserController@ajaxCommiToMoney');//ajax佣金转余额
    Route::get('user_m/commitobank', 'h5\View\UserController@commiTobank');//佣金转余额
    Route::post('user_m/ajaxcommitobank', 'h5\View\UserController@ajaxCommiTobank');//ajax佣金转余额
    Route::get('user_m/editpwd', 'h5\View\UserController@editpwd');//修改密码
    Route::get('user_m/account', 'h5\View\UserController@account');//云购详情
    Route::get('user_m/invite', 'h5\View\UserController@myInvite');//邀友记录
    Route::get('user_m/invite_ajax', 'h5\View\UserController@myInvite_ajax');//我的账户
    Route::get('user_m/inviteprize', 'h5\View\UserController@invitePrize');//邀友获奖记录
    Route::get('user_m/bribery', 'h5\View\UserController@myBriberyMoney');//我的红包
    Route::get('user_m/mycommission', 'h5\View\UserController@myCommission');//我的红包
    Route::get('user_m/show', 'h5\View\UserController@showRecord');//我的晒单
    Route::get('user_m/showorder/{oid}', 'h5\View\UserController@showOrder'); //晒单
    Route::post('user_m/showpic', 'h5\View\UserController@showPic');//我的晒单保存图片
    Route::post('user_m/savepics', 'h5\View\UserController@savePics');//我的晒单
    Route::get('user_m/editshow/{id}', 'h5\View\UserController@editShowOrder');//编辑我的晒单
    Route::get('user_m/showdetail/{id}', 'h5\View\UserController@showDetail');//晒单详情
    Route::get('user_m/showlist', 'h5\View\UserController@showlist');//我的已晒单列表
    Route::get('user_m/buy', 'h5\View\UserController@buyRecord');//我的云购记录
    Route::get('user_m/buydetail/{id}', 'h5\View\UserController@buyDetail');//云购码详情
    Route::get('user_m/setnickname', 'h5\View\UserController@setnickname');//我的云购记录
    Route::get('user_m/usercenter2', 'h5\View\UserController@usercenter2');//用户中心
    Route::get('user_m/score', 'h5\View\UserController@myScore');//我的积分
    Route::get('user_m/prize', 'h5\View\UserController@prizeRecord');//我的中奖记录
    Route::get('user_m/virtualprize/{id}', 'h5\View\UserController@virtualprize');//话费自动充值1
    Route::post('user_m/autorecharge', 'h5\View\UserController@autoRecharge');//话费自动充值2
    Route::post('user_m/confirmGood', 'Foreground\View\UserController@confirmGood');//确认收货
   	Route::get('user_m/help_m', 'h5\View\IndexController@help');//帮助页面
   	Route::get('user_m/article_m/{id}', 'h5\View\IndexController@article_content');//帮助页面内容
   	Route::get('user_m/level', 'h5\View\UserController@mylevel');//个人等级，需要移到上面的路由组
    //用户中心end

    Route::get('mycart_m', 'h5\View\ShoppingController@mycart');//我的购物车
    Route::get('mycart_m_empty', 'h5\View\ShoppingController@mycart_m_empty');//我的购物车-空购物车
    Route::post('addCart_m', 'h5\Service\ShoppingController@addCart');//添加购物车
    Route::post('deleteCart_m', 'h5\Service\ShoppingController@deleteCart');//删除购物车商品
    Route::post('clearCart_m', 'h5\Service\ShoppingController@clearCart');//清空购物车
    Route::post('createOrder_m', 'h5\Service\ShoppingController@createOrder');//刷新购物车付款金额
	Route::post('updateCart_m', 'h5\Service\ShoppingController@updateCart');

//	if(strpos($_SERVER['REQUEST_URI'], 'source=ios/pay_m') !== false) {
//		Route::post('/', 'h5\Service\PayController@pay');//支付
//	}elseif(strpos($_SERVER['REQUEST_URI'], 'source=ios/weixin_app/pay') !== false){
//		Route::post('/', 'h5\Service\WxAppPayController@pay');//ios app微信支付
//	}elseif(strpos($_SERVER['REQUEST_URI'], 'source=ios/user_m/recharge_now') !== false){
//		Route::get('/', 'h5\View\UserController@recharge_now');//支付
//	}

    Route::post('pay_m', 'h5\Service\PayController@pay');//支付页
    Route::post('refreshPayAmount_m', 'h5\Service\PayController@refreshPayAmount');//ajax刷新支付金额
    Route::post('paySubmit_m', 'h5\Service\PayController@paySubmit');//提交支付
    Route::post('chargeSubmit_m', 'h5\Service\ShoppingController@chargeSubmit');//提交支付
    Route::post('money_m/pay', 'h5\Service\MoneyPayController@pay');//余额支付
    Route::post('unionpay_m/pay', 'h5\Service\UnionPayController@pay');//银联支付
    Route::post('alipay_m/pay', 'h5\Service\AlipayController@pay');//支付宝支付
    Route::post('weixin_m/pay/', 'h5\Service\WxPayController@pay');//微信支付

	Route::post('weixin_m/unsuport', 'h5\Service\WxPayController@unsuport');//微信支付不支持跳转页

    Route::post('weixin_app/pay', 'h5\Service\WxAppPayController@pay');//app微信支付

    Route::get('wx_pay_s', 'h5\Service\WxPayController@wx_pay_s');//我的购物车
    Route::get('wx_pay_f', 'h5\Service\WxPayController@wx_pay_f');//我的购物车

    //支付后回调页面
    Route::post('unionpay_m/return','h5\Service\UnionPayController@redirect');

    Route::get('destory_login_m','h5\Service\AuthController@destoryLogin');//注销登陆

	//块乐豆充值页面
	Route::get('cz','h5\View\UserController@klBeanCharge');
	Route::post('cz_sub','h5\View\UserController@klBeanChargeSubmit');
    //系统消息
    Route::any('sysmessage','h5\View\UserController@sysMessage');
    Route::get('msginfo/{id}','h5\View\UserController@messageInfo');
});

Route::group(['middleware' => 'web'], function (){
	Route::get('index_m', 'h5\View\IndexController@index');//首页
   	Route::get('makemoney_m_new', 'h5\View\MakeMoneyController@makeMoney');//我要挣钱
   	Route::get('partner_m', 'h5\View\MakeMoneyController@partner');//我要挣钱
	Route::get('login_m', 'h5\View\AuthController@login'); //登录
	Route::get('union_m', 'h5\View\AuthController@union'); //关联账号
	Route::get('user_m/order_detail/{type?}', 'h5\View\UserController@orderDetail');//订单进度
	Route::get('find_m', 'h5\View\IndexController@find'); //晒单
	Route::get('product_m/{id}', 'h5\View\ProductsController@product');//商品详情
	Route::get('prod_m/{id}', 'h5\View\ProductsController@proCurObj'); 
	Route::get('productdetail_m/{id}', 'h5\View\ProductsController@productdetail');//商品详情
	Route::post('product_m/getbuyrecord','h5\Service\ProductsController@getAllBuyRecord');//获取该商品所有用户的购买信息

	Route::get('calculate_m/{id}', 'h5\View\ProductsController@calculate');//商品详情
	Route::get('agreement_m', 'h5\View\IndexController@agreement');//服务协议

	Route::get('usercenter', 'h5\View\IndexController@userCenter');//用户中心(未登录)


	Route::get('aboutus_m', 'h5\View\IndexController@aboutus');
	Route::get('jjjx_m', 'h5\View\IndexController@jjjx');
	Route::get('category_m', 'h5\View\ProductsController@productCatgory');//商品所有分类
	Route::get('search_m', 'h5\View\ProductsController@search');//搜索
    Route::get('search_cookie', 'h5\View\ProductsController@get_history');//搜索
	Route::get('search_m_result', 'h5\View\ProductsController@search_result');//搜索结果页
	Route::get('other_m', 'h5\View\IndexController@home');//搜索结果页
	Route::get('forgetpwd_m', 'h5\View\IndexController@forgetpwd');//找回密码
	Route::get('product_content_m', 'h5\View\IndexController@product_content');
	Route::get('wqjx_m', 'h5\View\IndexController@wqjx');//往期揭晓
	Route::get('selectperiods_m', 'h5\View\ProductsController@selectperiods');//期数查询
	Route::get('geturlbyperiod', 'h5\View\ProductsController@getUrlByPeriod');//获取期数对应的url
	Route::get('advise_m', 'h5\View\IndexController@advise');//建议反馈

	Route::get('guide_m', 'h5\View\IndexController@guide');//引导页
	Route::any('jiexiao_m', 'h5\View\IndexController@announcement');//正在揭晓的商品列表
	Route::post('/aferjx', 'h5\View\IndexController@aferLottery');//揭晓后更新信息 16.7.1 by baoyaoling
	Route::get('getlotteryafter', 'h5\View\IndexController@getLotteryAfter');//正在揭晓的商品列表
	Route::get('reg_m', 'h5\View\AuthController@register');//注册页面
	Route::post('register_m', 'h5\Service\AuthController@register');//注册页面
	Route::post('regSubmit_m', 'h5\Service\AuthController@regSubmit_m');//注册页面

//	Route::get('freeday_m', 'h5\View\FreeDayController@index');//天天免费

	Route::get('freeday_m', 'h5\View\RotaryController@index');//大转盘

    Route::get('cookie', 'h5\View\FreeDayController@index');//天天免费

    Route::get('share_m', 'h5\View\ShareController@index'); //晒单广场
    Route::get('sharePlus', 'h5\View\ShareController@sharePlus'); //晒单广场
    Route::get('sharedetail_m/{id}', 'h5\View\ShareController@sharedetail'); //晒单详情
    Route::post('share_m/pushcomment', 'h5\View\ShareController@pushComment');  //晒单点赞

    Route::post('user_m/login', 'h5\Service\AuthController@login');//登陆
    Route::post('user_m/setpwd', 'h5\View\UserController@setpwd');//设置密码
    Route::post('user_m/resetpwd', 'h5\View\UserController@resetpwd');//重置密码
    Route::post('checkVerifyCode_m', 'h5\Service\AuthController@checkVerifyCode');
    Route::get('him_m/getHisBuy/{uid}', 'h5\View\IndexController@getHisBuy');//他人购买记录
    Route::any('him_m/getFetchnoInfo', 'h5\View\IndexController@getFetchnoInfo');//中奖订单信息
    Route::any('him_m/getajxaHisBuy', 'h5\View\IndexController@getajxaHisBuy');//中奖订单信息
    Route::get('him_m/getHisBuy2', 'h5\View\HimController@getHisBuy');//他人购买记录
    Route::post('regverify_m', 'h5\Service\AuthController@sendSmsCode');  //注册验证码
    Route::post('mobileSendCode_m', 'h5\Service\AuthController@mobileSendCode');  //第三方绑定 发送验证码  16.6.28 by baoyaoling
    Route::post('bindUser_m', 'h5\Service\AuthController@bindUser');  //第三方绑定 发送验证码  16.6.28 by baoyaoling
    Route::post('regverify_m_set', 'h5\Service\AuthController@sendSmsCodeForget');  //注册验证码
    Route::get('captcha_m/{tmp}', 'h5\View\AuthController@captcha');

    Route::get('wxcallback_m', 'h5\Service\AuthController@wxCallBack');//微信登陆回调接口 16.6.14 by  baoyaoling
    Route::get('qqcallback_m', 'h5\Service\AuthController@qqCallBack');//qq登陆回调接口 16.6.16 by  baoyaoling
    //银联支付回调
    Route::post('unionpay_m/result', 'h5\Service\UnionPayController@result');

    Route::get('pay_fail', 'h5\Service\MoneyPayController@pay_fail');

    Route::get('oauth', 'OauthController@index');
});

/*------------------------------------------------------------------------------------------*/
/*---------------------------------H5路由结束-----------------------------------------------*/
/*------------------------------------------------------------------------------------------*/


/*----------------------API start----------------------*/
Route::group(['middleware' => 'web'], function (){
	Route::get('api/getUserBean', 'api\CcfaxController@getUserBean');  //获取用户块乐豆
	Route::post('api/addBean', 'api\CcfaxController@addBean');  //赠送块乐豆
});
/*----------------------API end----------------------*/
