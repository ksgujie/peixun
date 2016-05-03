@if (Session::has('success'))

	<div class="alert alert-success" style="margin:10px 15px 0px 15px" >
		<h4>{{ Session::get('success') }}</h4>
	</div>

@endif
	
@if (Session::has('danger'))

	<div class="alert alert-danger" style="margin:10px 15px 0px 15px" >
		<h4>{{ Session::get('danger') }}</h4>
	</div>

@endif

@if (Session::has('message'))

	<div class="alert alert-warning" style="margin:10px 15px 0px 15px" >
		<h4>{{ Session::get('message') }}</h4>
	</div>

@endif

