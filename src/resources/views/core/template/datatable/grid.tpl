@extends('layouts.app')
@section('content')

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">

		<div class="row align-items-center">
			<div class="border-0 mb-4">
				<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
					<h3 class="fw-bold mb-0">{{$info['module_name']}}</h3>
					<div class="col-auto d-flex w-sm-100">
						<a href="{{route($info['module_route'].'.create')}}" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Add {{$info['create_button']}}</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row clearfix g-3">
			<div class="col-sm-12">

				<div class="card">
					<div class="card-body">
							<div class="table-responsive">
							<table class="table  table-hover table-striped" id="dataTable" style="width: 100%">
								<thead>
									<tr>
										<td> SL </td>
										@foreach ($tableGrid as $tableItem)
											<td>{{$tableItem['field_name']}}</td>
										@endforeach
										<td>Action</td>
									</tr>
								</thead>
							</table>
							</div>
							
						</div>
					</div>
				</div>
			</div>	
					
		</div>
	</div>
</div>
@endsection

@push('footer')

<script>
	jQuery('#dataTable').DataTable({
        dom: 'Brftlip',
        buttons: [ 'csv', 'excel', 'pdf', 'print'],
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
        ajax: {
          url: "{{route($info['module_route'].'.show',0)}}",
          type: 'GET',
        },
        aLengthMenu: [
            [25, 50, 100, 500, 5000, -1],
            [25, 50, 100, 500, 5000, "All"]
         ],
         iDisplayLength: 25,
        "language": {"processing": '<span style="color:#4eb9fa;">LOADING...</span>'},
        "order": [[0, 'desc']],
        columns: [
            {data: 'DT_RowIndex',"className" : "text-center",orderable: false, searchable: false,},
			@foreach ($tableGrid as $tableItem)
			{data: '{{$tableItem['field_key']}}'},
			@endforeach
            {data: 'action', name: 'action', orderable: false, searchable: false, "className" : "text-center"},
        ]
      });
</script>
	
@endpush

