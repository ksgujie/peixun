@extends('layouts.main')

@section('content')

<div id="main_body">    
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
            <td> {{ $score->remark }} </td>
          <td>
          	  {{ HTML::link("score/del/".$score->id, '删除') }}
          </td>
        </tr>
@endforeach
    </table>

</div>

@stop