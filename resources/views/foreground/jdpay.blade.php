<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>支付跳转</title>
</head>

<body onLoad="javascript:document.E_FORM.submit()">
正在跳转支付...

<form action="{{$jump_url}}" method="post" name="E_FORM" style="display:none">
    <input type="hidden" name="v_mid"         value="{{$data['v_mid']}}">
    <input type="hidden" name="v_oid"         value="{{$data['v_oid']}}">
    <input type="hidden" name="v_amount"      value="{{$data['v_amount']}}">
    <input type="hidden" name="v_moneytype"   value="{{$data['v_moneytype']}}">
    <input type="hidden" name="v_url"         value="{{$data['v_url']}}">
    <input type="hidden" name="v_md5info"     value="{{$data['v_md5info']}}">
    <input type="hidden" name="remark2"       value="{{$data['remark2']}}">
</form>
</body>
</html>