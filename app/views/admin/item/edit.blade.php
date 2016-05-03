@extends('layouts.admin.main')

@section('content')

<div id="main_body">    

    {{Form::model($item, ['route'=>["itemEdit", $item->id] ])}}
    <table class="tb">
        <tr>
            <th colspan="2"><h3>修改项目</h3></th>
        </tr>
        <tr>
            <td class="td_w120">项目名称</td>
          <td>
         
          {{Form::text('name')}}
          {{Form::select('type', ['个人项目'=>'个人项目', '团体项目'=>'团体项目'])}}
          {{Form::submit('保存修改')}}
          <div style='color:red'>{{$errors->first('name')}}</div>
          </td>
        </tr>
        <tr>
            <td class="td_w120"></td>
            <td>
            
            </td>
        </tr>
    </table>
  {{Form::close()}}



</div>

@stop