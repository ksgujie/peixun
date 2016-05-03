@extends('layouts.admin.main')

@section('content')

<div id="main_body">    

    {{Form::open(['url'=>"admin/item/add"])}}
    <table class="tb">
        <tr>
            <th colspan="2"><h3>添加报名字段</h3></th>
        </tr>
        
        <tr>
            <td class="td_w120">名称</td>
          <td>
         
          {{Form::text('name')}}
          </td>
        
        <tr>
            <td class="td_w120">默认值</td>
          <td>
         
          {{Form::text('default')}}
          {{Form::submit('添加')}}
          </td>
        </tr>
        	  
        <tr>
            <td class="td_w120"></td>
            <td>
            
            </td>
        </tr>
    </table>
  {{Form::close()}}


  <table width="500" border="0" cellpadding="10" cellspacing="0" class="tb">
    <tr>
      <th colspan="3"><h3>已设项目</h3></th>
    </tr>
    <tr>
      <td class="td_w120"><strong>序号</strong></td>
      <td><strong>项目名称</strong></td>
      <td><strong>项目类别</strong></td>
      <td><strong>改/删</strong></td>
    </tr>
<!-- {{$i=0}} -->
@foreach ($items as $d)
<!-- {{$i++}} -->
    <tr>
      <td>{{$i}}</td>
      <td>{{$d->name}}</td>
      <td>{{$d->type}}</td>
      <td>
      {{HTML::link("admin/item/edit/$d->id", '修改')}}
      {{HTML::link("admin/item/del/$d->id", '删除', ['onclick'=>"return confirm(\"确认删除 $d->name ？\")"] )}}
      </td>
    </tr>
@endforeach
  </table>
</div>

@stop