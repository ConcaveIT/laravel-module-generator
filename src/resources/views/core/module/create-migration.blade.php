@extends('layouts.app')
@section('content')
<style>
    .parnet_item:nth-child(1) .delete_button{display:none;}
</style>

<div class="card mb-3">
    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Create New Database Table</h6> 
    </div>

    <div class="card-body">
        <form  method="post" novalidate action="{{route('module.generate.migration')}}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                        <div class="form-group row  mb-1">
                            <label for="ModuleTitle" class="col-sm-3 col-form-label">Table Title<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="table_name" class="form-control @error('table_name') is-invalid @enderror" required >
                                @error('table_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row  mb-1">
                            <label for="ModuleTitle" class="col-sm-3 col-form-label">Enable Soft Delete</label>
                            <div class="col-sm-9 col-form-label">
                                <input type="checkbox" name="softdelete" > YES
                            </div>
                        </div>
                </div>

                <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Column Name</td>
                                        <td>Data Type</td>
                                        <td>Length/Values</td>
                                        <td>Default</td>
                                        <td>Not Null ?</td>
                                        <td>KEY</td>
                                        <td>AI</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="parnet_item">
                                        <td>
                                            <input class="form-control " type="text" name="table[0][column_name]" placeholder="Column Name">
                                        </td>
                                        <td> 
                                            <select class="form-control" name="table[0][data_type]">
                                                <option value='text'>text</option>
                                                <option value='id'>id</option>
                                                <option value='bigInteger'>bigInteger</option>
                                                <option value='binary'>binary</option>
                                                <option value='boolean'>boolean</option>
                                                <option value='date'>date</option>
                                                <option value='dateTime'>dateTime</option>
                                                <option value='decimal'>decimal</option>
                                                <option value='double'>double</option>
                                                <option value='enum'>enum</option>
                                                <option value='float'>float</option>
                                                <option value='increments'>increments</option>
                                                <option value='integer'>integer</option>
                                                <option value='json'>json</option>
                                                <option value='longText'>longText</option>
                                                <option value='mediumIncrements'>mediumIncrements</option>
                                                <option value='mediumInteger'>mediumInteger</option>
                                                <option value='mediumText'>mediumText</option>
                                                <option value='nullableTimestamps'>nullableTimestamps</option>
                                                <option value='smallIncrements'>smallIncrements</option>
                                                <option value='smallInteger'>smallInteger</option>
                                                <option value='string'>string</option>
                                                <option value='time'>time</option>
                                                <option value='timestamp'>timestamp</option>
                                                <option value='timestamps'>timestamps</option>
                                                <option value='tinyIncrements'>tinyIncrements</option>
                                                <option value='tinyInteger'>tinyInteger</option>
                                                <option value='tinyText'>tinyText</option>
                                                <option value='unsignedBigInteger'>unsignedBigInteger</option>
                                                <option value='unsignedDecimal'>unsignedDecimal</option>
                                                <option value='unsignedInteger'>unsignedInteger</option>
                                                <option value='unsignedMediumInteger'>unsignedMediumInteger</option>
                                                <option value='unsignedSmallInteger'>unsignedSmallInteger</option>
                                                <option value='unsignedTinyInteger'>unsignedTinyInteger</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="table[0][data_length]" placeholder="Length/Values">
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="table[0][default_value]" placeholder="Default">
                                        </td>
                                        <td> <input type="checkbox" name="table[0][not_null]"></td>
                                        <td><input type="checkbox" name="table[0][table_key]"></td>
                                        <td><input type="checkbox" name="table[0][auto_increment]"></td>
                                        <td><a class="text-danger delete_button" href="javascript:void(0)"><i class="fa fa-1x fa-trash"></i></a></td>
                                    </tr>

                                    <tr class="button_tr">
                                        <td colspan="8"><a  data-input-count ="1" id="cloneBtn" class="btn btn-sm btn-secondary" href="javascript:void(0)"><i class="fa fa-1x fa-plus"></i> Add New Row</a></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                </div>

                <div class="form-group mb-4 text-right">
                    <p class="text-end"><button type="submit" class="btn btn-primary">Create Table</button></p>
                </div>
            </div>

        </form>
    </div>

</div>

@endsection


@push('script')
    <script>
        jQuery(document).on('click','#cloneBtn',function(){
            var clonedHtml = jQuery('.parnet_item:first').clone();
            var i = jQuery(this).attr('data-input-count');

            clonedHtml.find('input').each(function() {
                this.name = this.name.replace('[0]', '['+i+']');
            });

            clonedHtml.find('select').each(function() {
                this.name = this.name.replace('[0]', '['+i+']');
            });

            clonedHtml.insertBefore(".button_tr");
            jQuery(this).attr('data-input-count',Number(i)+1);

        });


        jQuery(document).on('click','.delete_button',function(){
            jQuery(this).closest('tr').remove();
        });

        

    </script>
@endpush
