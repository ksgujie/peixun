@extends('layouts.main')

@section('content')

<div id="main_body">
    {{Form::open(['url'=>'score/add'])}}
      <table class="tb">
        <tr>
            <th colspan="2"><h3>报名</h3></th>
        </tr>
        
        <tr>
          <td class="td_w120">项目</td>
            <td>{{ Form::select('f1', ['科技教师培训'=>'科技教师培训'] ) }}
            	{{ $errors->first('f1', '<div style="color:red">:message</div>') }}
<!-- 	<div style="color:blue">注：1.通过校教科室参加的论文/教案等评选活动已汇总好，不需要登记！</div> -->
		
             	
            </td>
        </tr>        
<!--        		
        <tr>
          <td class="td_w120">微信号</td>
            <td>
          {{ Form::text('f2') }}
            	{{ $errors->first('f2', '<div style="color:red">:message</div>') }}

            </td>
        </tr>        	
        
        <tr>
          <td class="td_w120">学历</td>
            <td>
          {{ Form::text('f3') }}
            	{{ $errors->first('f3', '<div style="color:red">:message</div>') }}
            </td>
        </tr>

        <tr>
          <td class="td_w120">是否参加苏州市培训</td>
          <td>
          {{ Form::select('f4', [''=>'请选择','是'=>'是','否'=>'否']) }}
           {{ $errors->first('dept', '<div style="color:red">:message</div>') }}
           
          </td>
        </tr>
-->

<!--        
        <tr>
          <td class="td_w120">成绩描述</td>
          <td>
          {{ Form::text('content', null, ['style'=>'width:100%', 'id'=>'content']) }}
           {{ $errors->first('content', '<div style="color:red">:message</div>') }}
	<div style="color:red">注：此项请尽量按照<strong>范例</strong>的格式填写，不要使用缩写等容易产生歧义的描述！</div>
	<div style="color:blue" id="example"></div>
           
          </td>
        </tr>

        <tr>
          <td class="td_w120">本校组织/负责部门</td>
          <td>
          {{ Form::select('dept', [''=>'请选择','校长室'=>'校长室','教导处'=>'教导处','德育处'=>'德育处','教科室'=>'教科室','教技室'=>'教技室','工会'=>'工会','其它'=>'其它']) }}
           {{ $errors->first('dept', '<div style="color:red">:message</div>') }}
           
          </td>
        </tr>
 -->
        <tr>
          <td class="td_w120">备注</td>
          <td>{{ Form::hidden('mark', null, ['style'=>'width:300px;height:80px;']) }}
          
          </td>
        </tr>

        <tr>
          <td class="td_w120"></td>
          <td>{{ Form::submit('确定') }}
        
          </td>
        </tr>
    </table>
  {{Form::close()}}

<!-- 以下为列表 -->
	<div style="color:blue">注：若某项填写错误，请删除后重新登记！</div>
      <table class="tb">
         <tr>
            <th colspan="8"><h3>已报名</h3></th>
        </tr>

<!--         <tr>
            <th><h3>序号</h3></th>
            <th><h3>项目</h3></th>
            <th><h3>等第/级别</h3></th>
            <th><h3>内容</h3></th>
            <th><h3>责任部门</h3></th>
            <th><h3>备注</h3></th>
            <th><h3>删除</h3></th>
        </tr> -->
        
<!-- {{$i=0}} -->
@foreach ($scores as $score)        
<!-- {{$i++}} -->
        <tr>
            <td style="width:50px;">{{$i}}</td>
            <td> {{ $score->f1 }} </td>
            <td> {{ $score->f2 }} </td>
            <td> {{ $score->f3 }} </td>
            <td> {{ $score->f4 }} </td>
            <td> {{ $score->f5 }} </td>
            <td> {{ $score->mark }} </td>
          <td>
          	  {{ HTML::link("score/del/".$score->id, '删除') }}
          </td>
        </tr>
@endforeach
    </table>

</div>
@stop