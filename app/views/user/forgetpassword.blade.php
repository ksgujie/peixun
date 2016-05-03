@extends('layouts.main')


<div style="width:800px; MARGIN-RIGHT: auto; MARGIN-LEFT: auto; ">
@section('content')

<style>
	input { width:500px;}
</style>

<div id="main_body">

<div id="myselect"> 
    {{Form::open(['url'=>'user/forgetpassword'])}}
      <table class="tb">
        <tr>
            <th colspan="2"><h3>找回密码</h3></th>
        </tr>
        
        <tr>
          <td class="td_w120">姓名</td>
            <td>
          {{ Form::text('username') }}
           {{ $errors->first('username', '<div style="color:red">:message</div>') }}
           <div style="color:blue">真实姓名</div>
            </td>
        </tr>

        <tr>
          <td class="td_w120">身份证号</td>
          <td>
          {{ Form::text('sfz') }}
           {{ $errors->first('sfz', '<div style="color:red">:message</div>') }}
            </td>
        </tr>

        <tr>
          <td class="td_w120"></td>
          <td>{{ Form::submit('提交') }}          </td>
        </tr>
    </table>
  {{Form::close()}}

</div>
</div>
</div>
@stop


