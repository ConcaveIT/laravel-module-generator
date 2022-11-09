@extends('layouts.app')

@section('content')

	<div class="card">
		<div class="card-body">
		@if(isset($data))
			<form action="{{route('{class}.update',$data->id)}}" method="post">
			@method('put')
		@else
			<form action="{{route('{class}.store')}}" method="post">
		@endif
			@csrf
				{form_html}
				<div class="form-group mb-4 mt-4 text-right">
					<p class="text-end"><button type="submit" class="btn btn-primary">Save Information</button></p>
				 </div>
			</form>
		</div>
	</div>
		 
@endsection

@push('script')
{script_html}
@endpush