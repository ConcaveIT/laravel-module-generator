@extends('layouts.app')
@section('content')

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">

		<div class="row align-items-center">
			<div class="border-0 mb-4">
				<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
					<h3 class="fw-bold mb-0">Menu Manage</h3>
					<div class="col-auto d-flex w-sm-100">
						<a href="{{route('sidemenu.create')}}" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Add Menu</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row clearfix g-3">
			<div class="col-sm-12">

				<div class="card">
					<div class="card-body">
							<div class="table-responsive">
								<table class="table  table-hover table-striped  " id="datatable">
									<thead>
										<tr>
											<td>SL</td>
											<td>Title</td>
											<td>Parent</td>
											<td>Type</td>
											<td>Position</td>
											<td>Module</td>
											<td>Action</td>
										</tr>
									</thead>

									<tbody>
										@foreach($results as $result)
											<tr>
												<td>{{$loop->iteration}}</td>
												<td>{{$result->title}}</td>
												<td>{{$result->parent_id}}</td>
												<td>{{$result->menu_type}}</td>
												<td>{{$result->position}}</td>
												<td>{{$result->module}}</td>
												<td>
													<div class="btn-group" role="group" aria-label="Basic outlined example">
														<a href="{{route('sidemenu.edit',$result->id )}}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
														<a href="{{route('sidemenu.destroy',$result->id )}}" class="delete_btn btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></a>
													</div>
												</td>
											
											</tr>
										@endforeach        						
									</tbody>
								
								</table>
							</div>
							
						</div>
					</div>
				</div>
			</div>	
					
		</div>
	</div>
</div>
@push('script')
	<script>
	    //  data table
	    $(document).ready(function() {
	        $('#datatable')
	        .addClass( 'nowrap' )
	        .dataTable();
	    });
	</script>
@endpush
@endsection

