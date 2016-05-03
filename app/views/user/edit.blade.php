@extends('layouts.main')


@section('content')

<style>
	input { width:500px;}
</style>

<div id="main_body">

<div id="myselect"> 
    {{Form::model($user)}}
      <table class="tb">
        <tr>
            <th colspan="2"><h3>修改个人信息</h3></th>
        </tr>
        
        <tr>
          <td class="td_w120">学校</td>
            <td>{{ Form::select('school_id', School::getall() ) }}
            	{{ $errors->first('school_id', '<div style="color:red">:message</div>') }} </td>
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
          <td class="td_w120">性别</td>
          <td>
          {{ Form::select('sex', ['男'=>'男','女'=>'女'] ) }}
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
          <td class="td_w120">电话</td>
          <td>
                    {{ Form::text('tel') }}
           {{ $errors->first('tel', '<div style="color:red">:message</div>') }}
             </td>
        </tr>

        <tr>
          <td class="td_w120">邮箱</td>
          <td>
                    {{ Form::text('email') }}
           {{ $errors->first('email', '<div style="color:red">:message</div>') }}
           </td>
        </tr>
        <tr>
          <td class="td_w120">联系地址</td>
          <td>
                    {{ Form::text('address') }}
           {{ $errors->first('address', '<div style="color:red">:message</div>') }}
          </td>
        </tr>
        <tr>
          <td class="td_w120"></td>
          <td>{{ Form::submit('保存') }}          </td>
        </tr>
    </table>
  {{Form::close()}}

</div>
</div>
@stop


