var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:'11:00'
		});
	}else
		this.setOptions({
			minTime:'8:00'
		});
};
$('.datetimepicker7').datetimepicker();
$('#datetimepicker8').datetimepicker({
	onGenerate:function( ct ){
		$(this).find('.xdsoft_date')
			.toggleClass('xdsoft_disabled');
	},
	minDate:'-1970/01/2',
	maxDate:'+1970/01/2',
	timepicker:false
});

function check()
{
	var starttime=$("#start_time").val();
	var endtime=$("#end_time").val();
	if(starttime=='' || endtime=='' )
	{
//		layer.msg('时间不能为空');
//	    return false;
	}
	return true;
	
	
}
