<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>昆山科技教师培训报名</title>
{{HTML::style('css/bootstrap.css')}}
{{HTML::style('css/bootstrap-theme.css')}}
{{HTML::style('css/reset.css')}}
{{HTML::style('css/main.css')}}

{{-- HTML::script('js/bootstrap.min.js') --}}
{{HTML::script('js/jquery.min.js')}}

{{HTML::script('js/jquery.cxselect.js')}}



<style>
	td {line-height:30px;}
</style>

</head>

<body>
	@include('_message')
	@yield('content')

<script>
$.cxSelect.defaults.url = '{{asset('js/type_level.json')}}';
$.cxSelect.required = true;

$('#myselect').cxSelect({
	selects: ['type', 'level']
});

$(".type").change( function() {
	switch($('.type').val()){
	    case "辅导学生比赛":
	    	var example="辅导XXX学生参加昆山市/苏州市/江苏省XXX比赛";
	     break;
	    case "辅导学生发表":
	    	var example="辅导XXX学生的作文《XXX》发表于《XXX》杂志（报刊）2014年第X期";
	     break;
	    case "教师比赛":
	    	var example="2014年昆山市/苏州市/江苏省XXX竞赛";
	     break;
	    case "课件获奖":
	    	var example="课件《XXX》参加昆山市/苏州市/江苏省XXX比赛";
	     break;
	    case "论文发表":
	    	var example="论文《XXX》发表于《XXX》杂志2014年第XX期";
	     break;
	    case "论文获奖":
	    	var example="论文《XXX》参加昆山市/苏州市/江苏省XXX比赛";
	     break;
	    case "教案获奖":
	    	var example="教案《XXX》参加昆山市/苏州市/江苏省XXX比赛";
	     break;
	    case "公开课":
	    	var example="在XXX活动中上公开课《XXX》";
	     break;
	    case "讲座":
	    	var example="在XXX活动中作《XXX》讲座";
	     break;
	    case "其它":
	    	var example="按实际情况填写";
	     break;
	   }
	 if ($('.type').val().length>0) {
     	$('#example').html("<strong>范例：" + example + '</strong>');
     	$('#content').val(example);
     }
});

</script>

</body>
</html>