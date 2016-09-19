<?php
	function invite_code() {
		if(empty(session('user.id'))){  //未登录状态
			//获取用户邀请码
			$invite_code = isset($_GET['code'])?(int)$_GET['code']:'';
			if(!empty($invite_code)){
				$member = DB::select("SELECT `usr_id` FROM `tab_member` WHERE `usr_id`='$invite_code'");
				if(!empty($member)){
					session(['invite_code' => $invite_code]);
				}
			}
		}
	}
	
	//根据gid获取当前商品最新一期oid
	function get_oid($gid=0){
		$res = DB::select("SELECT `id` FROM `tab_object` WHERE `g_id`='$gid' ORDER BY `periods` DESC LIMIT 1");
		return $res[0]->id;
	}