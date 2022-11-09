@extends('layouts.app')
@section('content')

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Activity Logs</h3>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row clearfix g-3">
          <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:5%">Log ID</th>
                                    <th style="width:20%">Description</th>
                                    <th style="width:20%">Data</th>
                                    <th style="width:20%">Model Name</th> 
                                    <th style="width:20%">Causer</th>  
                                    <th style="width:10%">Date/Time</th>  
                                    <th style="width:5%">Actions</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activityLogs as $log)
                                <tr>
                                    <td><a href="#" class="fw-bold text-secondary">{{$log->id}}</a></td>
                                    <td>{{$log->description}}</td>
                                    <td>
                                       @if($log->subject)
                                            @foreach( json_decode($log->subject) as $key=>$val)
                                                <small class="display-block"><b>{{$key}}:</b>{{$val}},</small>
                                            @endforeach
                                       @endif
                                    </td>
                                    <td>{{$log->subject_type}}</td>
                                    <td>
                                        @if($log->causer)
                                            @foreach( json_decode($log->causer) as $key=>$val)
                                                <small class="display-block"><b>{{$key}}:</b>{{$val}}</small>
                                            @endforeach
                                       @endif
                                    </td>
                                    <td>{{$log->created_at}}</td>
                                   <td>
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
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
