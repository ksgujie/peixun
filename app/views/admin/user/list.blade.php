@extends('layouts.admin.main')

@section('content')

<div id="main_body">    
	
    <table class="tb">
@foreach (array_keys($users) as $type)
        <tr>
            <th colspan="8"><h3 align="left"><strong>用户列表{{$type}}</strong></h3></th>
      </tr>
        <tr>
          <th>序号</th>
          <th>姓名</th>
          <th>姓别</th>
          <th>学校</th>
          <th>电话</th>
          <th>身份证</th>
          <th>邮箱</th>
          <th>密码重置</th>
      </tr>
	<!-- {{$i=0}} -->
    @foreach ($users[$type] as $user)
	<!-- {{$i++}} -->
        <tr>
            <td> {{$i}} </td>
            <td>{{$user->username}}</td>
            <td>{{$user->sex}}</td>
            <td>{{$user->school->name}}</td>
            <td>{{$user->tel}}</td>
            <td>{{$user->sfz}}</td>
            <td>{{$user->email}}</td>
            <td>{{HTML::link("admin/user/resetpwd/$user->id", '密码重置')}}</td>
        </tr>
       
    @endforeach
        <tr>
            <td colspan="8"></td>
        </tr>    	
@endforeach
    </table>
    


</div>

@stop