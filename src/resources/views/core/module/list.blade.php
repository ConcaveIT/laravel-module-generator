@extends('layouts.app')
@section('content')

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Modules</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a  href="{{route('module.create.migration')}}" class="mr-2 btn btn-secondary btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Create Database Table</a>
                        <a href="{{route('module.create')}}" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Add Modules</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix g-3">
          <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Modules ID</th>
                                    <th>Title</th>
                                    <th>Controller</th>
                                    <th>Database</th> 
                                    <th>Created Date</th> 
                                    <th>Status</th>   
                                    <th class="text-center" >Actions</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td><a href="#" class="fw-bold text-secondary">#WRB-{{$item->id}}</a></td>
                                    <td>{{$item->module_title}}</td>
                                    <td>{{$item->controller_name}}Controller</td>
                                    <td>{{$item->database_table_name}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        @if($item->status == 1)
                                        <span class="badge bg-success">Enabled</span>
                                        @else
                                        <span class="badge bg-danger">Disabled</span>
                                        @endif
                                    </td>
                                
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <a href="{{route( strtolower($item->controller_name).'.index')}}" class="btn btn-outline-secondary"><i class="icofont-eye text-warning"></i></a>
                                            <a href="{{route('module.edit',$item->id)}}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                            <a href="{{route('module.destroy',$item->id )}}" class="delete_btn btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
          </div>
        </div><!-- Row End -->
    </div>
</div>

@endsection

@push('script')
<script>
    // project data table
    $(document).ready(function() {
        $('#myProjectTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
        $('.deleterow').on('click',function(){
        var tablename = $(this).closest('table').DataTable();  
        tablename
                .row( $(this)
                .parents('tr') )
                .remove()
                .draw();

        } );
    });
</script>

@endpush
