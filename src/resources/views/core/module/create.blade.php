@extends('layouts.app')
@section('content')

<div class="card mb-3">
    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">New Module</h6> 
    </div>
    <div class="card-body">
        <form  method="post" novalidate action="{{route('module.store')}}">
            @csrf
            <div class="row g-3">

                <div class="col-md-6">
                    
                    <div class="form-group mb-2">
                        <label class="form-label">Module Title<span class="text-danger">*</span></label>
                        <input type="text" name="module_title" value="{{old('module_title')}}" class="form-control @error('module_title') is-invalid @enderror" required>
                       
                        @error('module_title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Controller Name<span class="text-danger">*</span></label>
                        <input type="text" name="controller_name" value="{{old('controller_name')}}" class="form-control @error('controller_name') is-invalid @enderror " required>
                        @error('controller_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group mb-2">
                        <label class="form-label">Grid/Table Type<span class="text-danger">*</span></label>
                        <select name="grid_table_type" class="form-control @error('grid_table_type') is-invalid @enderror" required>
                            <option value="native" @if(old('controller_name') == 'native') selected @endif>Laravel Native</option>
                            <option value="datatable" @if(old('controller_name') == 'datatable') selected @endif >Datatable</option>
                        </select>

                        @error('grid_table_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Database Table<span class="text-danger">*</span></label>
                        <select name="database_table_name" class="form-control @error('database_table_name') is-invalid @enderror" required>
                            @foreach($tables as $table)
                                @foreach ($table as $key => $value)
                                <option value="{{$value}}" @if(old('database_table_name') == $value ) selected @endif >{{$value}}</option>
                                @endforeach
                            @endforeach
                        </select>

                        @error('database_table_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>



                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">Permission Title<span class="text-danger">*</span></label>
                        <input type="text" name="permission_title" value="{{old('permission_title')}}"  class="form-control @error('permission_title') is-invalid @enderror " required>
                        @error('permission_title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                   
                    <div class="form-group mb-2">
                        <label class="form-label">Module Description</label>
                        <textarea name="module_description" class="form-control @error('module_description') is-invalid @enderror " rows="4" cols="30" required>{{old('permission_title')}}</textarea>
                        @error('module_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label mr-2">Status<span class="text-danger">*</span></label>
                        
                        <label class="fancy-radio mr_15">
                            <input type="radio" name="status" value="1"  @if(old('status') == 1 ) checked @endif data-parsley-errors-container="#error-radio" required>
                            <span><i></i>Enable</span>
                        </label>
                        <label class="fancy-radio">
                            <input type="radio" name="status" value="0"  @if(old('status') == 0 ) checked @endif required>
                            <span><i></i>Disable</span>
                        </label>
                        <p id="error-radio"></p>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label mr-2">Soft Delete Available?<span class="text-danger">*</span></label>
                        
                        <label class="fancy-radio mr_15">
                            <input type="checkbox" name="softdelete"  @if(old('softdelete') == 1 ) checked @endif  required>
                            <span><i></i>YES</span>
                        </label>
                    </div>


                </div>


            </div>
            <p class="text-end"><button type="submit" class="btn btn-primary">Create Module</button></p>
        </form>
    </div>
</div>


@endsection
