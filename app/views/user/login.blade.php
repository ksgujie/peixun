<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>登录</title>

<script>
	if( window.top != window.self ){
		top.location.href=window.self;
		
     }
</script>


{{HTML::style('css/bootstrap.css')}}
{{HTML::style('css/bootstrap-theme.css')}}
<!-- {{HTML::style('css/reset.css')}} -->
{{HTML::style('css/login.css')}}
{{-- HTML::script('js/bootstrap.min.js') --}}
{{HTML::script('js/jquery.min.js')}}

</head>

<body>

<div style="width:600px; margin:0 auto">
	@include("_message")
</div>

<!-- 登陆外围 -->
<br />
<br />
	
<!-- <div id="login_wrap"> -->
<center>
<div style="color:#ffffff">
    {{Form::open(['url'=>'user/login'])}}
   <h1>登 录</h1>
	  	姓名{{Form::select('id', User::getAll(), null )}}
	  	
	  	密码{{Form::password('password')}}
	  {{Form::submit('登 录')}}

  {{Form::close()}}
  
  
  
  <table align="center" border="0" width="400">
      <tr>
          <td>已报名：{{Score::count()}} 人</td>
          <td> {{Html::link('user/reg','新用户注册',['style'=>'color:#ffffff'])}} </td>
          <td>{{Html::link('user/forgetpassword','忘记密码？',['style'=>'color:#ffffff'])}} </td>
      </tr>
  </table>
  
</div>
</center>
<!-- </div> -->


</body>
</html>