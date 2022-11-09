@extends('layouts.app')
@section('content')

<style>
    .delete_item {
        font-size: 21px;
        margin-top: 8px;
        cursor: pointer;
    }
    .trigger_bars{
        display: none;
    }

</style>

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">

        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Update {{$moduleData->module_title}}</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a class="btn btn-warning btn-set-task w-sm-100 mr-2 text-white"  href="{{route('module.index')}}"> <i class="fa fa-bars"></i> Module List</a>
                        <a class="btn btn-dark btn-set-task w-sm-100" target="_blank" href="{{route( strtolower($moduleData->controller_name).'.index')}}"> <i class="fa fa-eye"></i> View Module</a>
                    </div>
                </div>
            </div>
        </div>

<form method="post" action="{{route('module.update',$moduleData->id)}}">
    @csrf
    @method('put')
    <div class="card mb-3">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#nav-details" role="tab">Module Information</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#nav-table" role="tab">Table Settings</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#nav-form" role="tab">Form Settings</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#nav-permission" role="tab">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#nav-builder" role="tab">Build Codes</a></li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-details" role="tabpanel">
                    
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">

                        <div class="form-group row  mb-1">
                            <label for="ModuleTitle" class="col-sm-3 col-form-label">Module Title <span class="text-danger">*</span> </label>
                            <div class="col-sm-9">
                                <input type="text" name="module_title" class="form-control" value="{{$moduleData->module_title}}">
                            </div>
                        </div>

                        <div class="form-group row  mb-1">
                            <label for="ModuleTitle" class="col-sm-3 col-form-label">Controller</label>
                            <div class="col-sm-9">
                                <input type="text"  class="form-control" value="{{$moduleData->controller_name}}" disabled>
                            </div>
                        </div>


                        <div class="form-group row  mb-1">
                            <label for="ModuleTitle" class="col-sm-3 col-form-label">Database Table</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{$moduleData->database_table_name}}" disabled>
                            </div>
                        </div>


                        <div class="form-group row mb-1">
                            <label class="form-label col-sm-3">Grid/Table Type<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="grid_table_type" class="form-control @error('grid_table_type') is-invalid @enderror" required>
                                    <option value="native" @if($moduleData->grid_table_type == 'native') selected @endif>Laravel Native</option>
                                    <option value="datatable" @if($moduleData->grid_table_type == 'datatable') selected @endif >Datatable</option>
                                </select>
        
                                @error('grid_table_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        

                        <div class="form-group row  mb-1">
                            <label for="ModuleTitle" class="col-sm-3 col-form-label">Soft Delete?</label>
                            <div class="col-sm-9">
                             <input type="checkbox" name="softdelete" class="col-form-label" @if($moduleData->softdelete) checked @endif> YES
                               
                            </div>
                        </div>

                        </div>
                        <div class="col-md-6">
                          
                            <div class="form-group row mb-1">
                                <label for="ModuleTitle" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                <textarea name="module_description" class="form-control @error('module_description') is-invalid @enderror" rows="3" cols="30">{{$moduleData->module_description}}</textarea>
                                    @error('module_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row  mb-1">
                                <label for="ModuleTitle" class="col-sm-3 col-form-label">Self Data Field Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="selfdata_field_name"  class="form-control" value="{{$moduleData->selfdata_field_name}}">
                                </div>
                            </div>

                            <div class="form-group row  mb-1">
                                <label for="ModuleTitle" class="col-sm-3 col-form-label">Permission Title</label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$moduleData->permission_title}}" disabled>
                                </div>
                            </div>
                            <div class="form-group row  mb-1">
                                <label for="ModuleTitle" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" name="status" id="flexSwitchCheckDefault" {{ $moduleData->status == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-table" role="tabpanel">
                    <table class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Field</th>
                                <th>Title / Caption</th>
                                <th>Format Type</th>
                                <th>Format Value 
                                    <span 
                                        type="button" 
                                        data-bs-toggle="popover" 
                                        title="Function Formats" 
                                        data-bs-html="true" 
                                        data-bs-content="
                                            Date Time - <code>d M, h:ia</code> <br>
                                            Image - <code>/uploads/images</code> <br>
                                            File - <code>/uploads/file</code> <br>
                                            Link - <code>https://example.com  </code><br>
                                            Function (Helper.php) - <code> getUppercase:arg1:arg2:arg3 </code>
                                        ">
                                        <i class="fa fa-info-circle text-info"></i>
                                    </span>
                                </th>
                                <th>Options</th>
                            </tr>
                        </thead>

                                                    
                        @php 
                            $configuration = $moduleData->configuration;
                            $table_configuration = isset(json_decode($configuration)->table_configuration) ? json_decode($configuration)->table_configuration : [];
                            $form_configuration = isset(json_decode($configuration)->form_configuration) ? json_decode($configuration)->form_configuration : [];
                        @endphp


                        <tbody class="sortable">
                            @foreach($columns as $item)
                            <?php 
                                $fieldName = isset($table_configuration->{$item}->field_name)  ? $table_configuration->{$item}->field_name : '';
                                $listView = isset($table_configuration->{$item}->listview) ? true : false;
                                $format = isset($table_configuration->{$item}->format) ? $table_configuration->{$item}->format : '';
                                $format_value = isset($table_configuration->{$item}->format_value) ? $table_configuration->{$item}->format_value : '';

                                $tableFieldRelationDatabase          = isset($table_configuration->{$item}->relation_database)  ? $table_configuration->{$item}->relation_database : '';
                                $tableFieldRelationDatabaseKey       = isset($table_configuration->{$item}->relation_database_key)  ? $table_configuration->{$item}->relation_database_key : '';
                                $tableFieldRelationDatabaseDisplay1  = isset($table_configuration->{$item}->relation_database_display1)  ? $table_configuration->{$item}->relation_database_display1 : '';
                                $tableFieldRelationDatabaseDisplay2  = isset($table_configuration->{$item}->relation_database_display2)  ? $table_configuration->{$item}->relation_database_display2 : '';
                                $tableFieldRelationDatabaseDisplay3  = isset($table_configuration->{$item}->relation_database_display3)  ? $table_configuration->{$item}->relation_database_display3 : '';
                                $tableFieldAllowMultiple             = isset($table_configuration->{$item}->allow_multiple)  ? 'checked' : '';
                               
                                if(!$fieldName){
                                    $fieldName = ucwords(str_replace('_',' ',$item));
                                }
                             ?>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td> {{$item}} 
                                        
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="{{'#linkModal_'.$item}}" ><i class="fa fa-link float-end" aria-hidden="true"></i></a>
                                     <!-- Link Modal -->
                                    <div class="modal fade" id="{{'linkModal_'.$item}}" tabindex="-1" aria-labelledby="{{'linkModalLabel_'.$item}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title " id="{{'linkModalLabel_'.$item}}">Link <b class="text-primary">{{$item}}</b>to another table</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="section_database_data">

                                                        <div class="form-group row mb-1">
                                                            <div class="col-sm-3 col-form-label">Database</div>
                                                            <div class="col-sm-9 col-form-label">
                                                                <select name="table_configuration[{{$item}}][relation_database]"  class="form-control database_table_trigger">
                                                                    <option value="-1" disabled selected>--Select Table --</option>
                                                                    @foreach($tables as $table)
                                                                        @foreach ($table as $key => $value)
                                                                            <option value="{{$value}}" @if($tableFieldRelationDatabase == $value) selected @endif >{{$value}}</option>
                                                                        @endforeach
                                                                    @endforeach
                                                                </select>
                                                                
                                                            </div>
                                                        </div> 


                                                        <div class="form-group row mb-1">
                                                            <div class="col-sm-3 col-form-label">Relation Key</div>
                                                            <div class="col-sm-9 col-form-label">
                                                                <select data-selected-value="{{$tableFieldRelationDatabaseKey}}" name="table_configuration[{{$item}}][relation_database_key]" class="form-control relationKey"></select>
                                                            </div>
                                                        </div> 

                                                        <div class="form-group row mb-1">
                                                            <div class="col-sm-3 col-form-label">Display 1</div>
                                                            <div class="col-sm-9 col-form-label">
                                                                <select data-selected-value="{{$tableFieldRelationDatabaseDisplay1 }}" name="table_configuration[{{$item}}][relation_database_display1]" class="form-control display1"></select>
                                                            </div>
                                                        </div> 

                                                        <div class="form-group row mb-1">
                                                            <div class="col-sm-3 col-form-label">Display 2</div>
                                                            <div class="col-sm-9 col-form-label">
                                                                <select data-selected-value="{{$tableFieldRelationDatabaseDisplay2 }}" name="table_configuration[{{$item}}][relation_database_display2]" class="form-control display2"></select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row mb-1">
                                                            <div class="col-sm-3 col-form-label">Display 3</div>
                                                            <div class="col-sm-9 col-form-label">
                                                                <select data-selected-value="{{$tableFieldRelationDatabaseDisplay3 }}" name="table_configuration[{{$item}}][relation_database_display3]" class="form-control display3"></select>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>


                                                <div class="modal-footer">
                                                    <a href="javascript:void(0)" class="btn btn-primary" data-bs-dismiss="modal">Save changes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    </td>
                                    <th>
                                        <div class="form-group">
                                            <input type="text" name="table_configuration[{{$item}}][field_name]" class="form-control" value="{{ $fieldName }}">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="form-group">

                                            @php
                                                $format_options = [
                                                    'default' => 'Default',
                                                    'select' => 'Select',
                                                    'image' => 'Image',
                                                    'multipleimage' => 'Multiple Image',
                                                    'link' => 'Link',
                                                    'file'  => 'File',
                                                    'multiplefile'  => 'Multiple File',
                                                    'datetime' => 'Date Time',
                                                    'html' => 'Html',
                                                    'function' => 'Custom Function',
                                                ];
                                            @endphp

                                            <select name="table_configuration[{{$item}}][format]" id="format_option" class="form-control">
                                                @foreach($format_options as $key => $val)
                                                    <option value="{{ $key}}" @if($format == $key) selected  @endif>{{$val}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </th>

                                    <th>
                                        <div class="form-group">
                                            <input type="text" name="table_configuration[{{$item}}][format_value]" class="form-control" value="{{ $format_value }}">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="form-group">
                                            <label class="fancy-radio">
                                                <input type="checkbox" name="table_configuration[{{$item}}][listview]"  @if($listView) checked @endif  >
                                                <span><i></i>Listview</span>
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="nav-form" role="tabpanel">
                    <table class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Field</th>
                                <th>Field Name</th>
                                <th>Type</th>
                                <th></th>
                                <th>Validation</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($columns as $item)

                            @php 
                                $formFieldName                      = isset($form_configuration->{$item}->field_name)  ? $form_configuration->{$item}->field_name : Helper::sanitizeField($item);
                                $formFieldType                      = isset($form_configuration->{$item}->type)  ? $form_configuration->{$item}->type : '';
                                $formFieldValidation                = isset($form_configuration->{$item}->validation)  ? $form_configuration->{$item}->validation : '';
                                $formFieldSearchable                = isset($form_configuration->{$item}->searchable)  ? 'checked' : '';
                                $formFieldFilterable                = isset($form_configuration->{$item}->filterable)  ? 'checked' : '';
                                $formFieldAllowMultiple             = isset($form_configuration->{$item}->allow_multiple)  ? 'checked' : '';
                                $formFieldParentFilter              = isset($form_configuration->{$item}->parent_filter)  ? $form_configuration->{$item}->parent_filter : '';
                                $formFieldDataType                  = isset($form_configuration->{$item}->data_type)  ? $form_configuration->{$item}->data_type : '';
                                $formFieldCustomData                = isset($form_configuration->{$item}->custom_data)  ? $form_configuration->{$item}->custom_data : [];
                                $formFieldRelationDatabase          = isset($form_configuration->{$item}->relation_database)  ? $form_configuration->{$item}->relation_database : '';
                                $formFieldRelationDatabaseKey       = isset($form_configuration->{$item}->relation_database_key)  ? $form_configuration->{$item}->relation_database_key : '';
                                $formFieldRelationDatabaseDisplay1  = isset($form_configuration->{$item}->relation_database_display1)  ? $form_configuration->{$item}->relation_database_display1 : '';
                                $formFieldRelationDatabaseDisplay2  = isset($form_configuration->{$item}->relation_database_display2)  ? $form_configuration->{$item}->relation_database_display2 : '';
                                $formFieldRelationDatabaseDisplay3  = isset($form_configuration->{$item}->relation_database_display3)  ? $form_configuration->{$item}->relation_database_display3 : '';
                            @endphp


                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$item}}
                                    <input type="hidden" name="form_configuration[{{$item}}][field_key]" class="form-control" value="{{ $item }}">
                                </td>
                                
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="form_configuration[{{$item}}][field_name]" class="form-control" value="{{ $formFieldName }}">
                                    </div>
                                </td>

                                <td>
                                    @php 
                                        $types = [
                                            'text'  => 'Text',
                                            'textarea' => 'Textarea',
                                            'textareawitheditor' => 'Textarea With Editor',
                                            'number'    => 'Number',
                                            'select' => 'Select Option',
                                            'file' => 'File',
                                            'multiplefiles' => 'Multiple Files',
                                            'image' => 'Image',
                                            'multipleimages' => 'Multiple Images',
                                            'radio' => 'Radio',
                                            'checkbox' => 'Checkbox',
                                            'date' => 'Date',
                                            'datetime' => 'Date Time',
                                            'hidden' => 'Hidden',
                                            'primary' => 'Primary',
                                        ];

                                    @endphp

                                    <select name="form_configuration[{{$item}}][type]" data-modal-id="{{'optionModal_'.$item}}" class="form-control trigger_option">
                                        @foreach($types as $key=>$val)
                                            <option value="{{$key}}"  @if($formFieldType == $key) selected @endif>{{$val}}</option>
                                        @endforeach
                                    </select>

                                    <!-- Modal -->
                                    <div class="modal fade" id="{{'optionModal_'.$item}}" tabindex="-1" aria-labelledby="{{'optionModalLabel_'.$item}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title " id="{{'optionModalLabel_'.$item}}">Choose option for <b class="text-primary">{{ucwords($item)}}</b></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="dynamicHtml">

                                                        <div class="form-group row  mb-1">
                                                            <label class="col-sm-4 col-form-label">Data Type<span class="text-danger">*</span> </label>
                                                            <div class="col-sm-4 col-form-label">
                                                                <label class="fancy-radio">
                                                                    <input type="radio" name="form_configuration[{{$item}}][data_type]" value="custom" class="trigger_data_type" @if($formFieldDataType == 'custom') checked @endif>
                                                                    <span><i></i>Custom</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-4 col-form-label type_database">
                                                                <label class="fancy-radio">
                                                                    <input type="radio" name="form_configuration[{{$item}}][data_type]" value="database" class="trigger_data_type" @if($formFieldDataType == 'database') checked @endif >
                                                                    <span><i></i>Database</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="section_custom_data form-group row  mb-1">
                                                            <div class="col-sm-10">
                                                            @php $itemKeyArray = [0]; 
                                                            
                                                            @endphp
                                                                @if($formFieldCustomData)
                                                                    @foreach($formFieldCustomData as $key=>$cData)
                                                                        <div class="row cloned_item">
                                                                            <div class="col-sm-3 col-form-label">
                                                                                <p class="text-end"><i class=" delete_item text-danger fa fa-trash"></i></p>
                                                                            </div>
                                                                            <div class="col-sm-9 col-form-label">
                                                                                <label class="fancy-radio" style="width:48%;float: left;margin-right: 3px;">
                                                                                    <input type="text" name="form_configuration[{{$item}}][custom_data][{{$key}}][name]" value="{{$cData->name}}" placeholder="Name"  class="form-control">
                                                                                </label>
                                                                                <label class="fancy-radio" style="width:48%;float: left;">
                                                                                    <input type="text" name="form_configuration[{{$item}}][custom_data][{{$key}}][value]" value="{{$cData->value}}" placeholder="Value" class="form-control">
                                                                                </label>
                                                                            </div> 
                                                                        </div>
                                                                        @php $itemKeyArray[] = $key;  @endphp
                                                                    @endforeach
                                                                @endif
                                                                <span class="parent_clone_section"></span>

                                                            </div>

                                                            @php 
                                                            $maxItem = max($itemKeyArray);
                                                            $maxItem = ($maxItem > 0) ? $maxItem+1 : $maxItem; 
                                                            @endphp
                                
                                                            <div class="col-sm-2 col-form-label">
                                                                <a href="javascript:void(0)" data-modal-id="{{'optionModal_'.$item}}" data-item-name="{{$item}}" data-count-number="{{$maxItem}}"  class="btn btn-primary btn-sm clone_button"> <i class="fa fa-plus"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="section_database_data">
                                                        
                                                            <div class="form-group row mb-1">
                                                                <div class="col-sm-3 col-form-label">Database</div>
                                                                <div class="col-sm-9 col-form-label">
                                                                    <select name="form_configuration[{{$item}}][relation_database]"  class="form-control database_table_trigger">
                                                                        <option value="-1" disabled selected>--Select Table --</option>
                                                                        @foreach($tables as $table)
                                                                            @foreach ($table as $key => $value)
                                                                                <option value="{{$value}}" @if($formFieldRelationDatabase == $value) selected @endif >{{$value}}</option>
                                                                            @endforeach
                                                                        @endforeach
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div> 


                                                            <div class="form-group row mb-1">
                                                                <div class="col-sm-3 col-form-label">Relation Key</div>
                                                                <div class="col-sm-9 col-form-label">
                                                                    <select data-selected-value="{{$formFieldRelationDatabaseKey}}" name="form_configuration[{{$item}}][relation_database_key]" class="form-control relationKey"></select>
                                                                </div>
                                                            </div> 
 
                                                            <div class="form-group row mb-1">
                                                                <div class="col-sm-3 col-form-label">Display 1</div>
                                                                <div class="col-sm-9 col-form-label">
                                                                    <select data-selected-value="{{$formFieldRelationDatabaseDisplay1 }}" name="form_configuration[{{$item}}][relation_database_display1]" class="form-control display1"></select>
                                                                </div>
                                                            </div> 

                                                            <div class="form-group row mb-1">
                                                                <div class="col-sm-3 col-form-label">Display 2</div>
                                                                <div class="col-sm-9 col-form-label">
                                                                    <select data-selected-value="{{$formFieldRelationDatabaseDisplay2 }}" name="form_configuration[{{$item}}][relation_database_display2]" class="form-control display2"></select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row mb-1">
                                                                <div class="col-sm-3 col-form-label">Display 3</div>
                                                                <div class="col-sm-9 col-form-label">
                                                                    <select data-selected-value="{{$formFieldRelationDatabaseDisplay3 }}" name="form_configuration[{{$item}}][relation_database_display3]" class="form-control display3"></select>
                                                                </div>
                                                            </div>

                                                        </div>



                                                        <div class="form-group row  mb-1">
                                                            <label class="col-sm-3 col-form-label">Parent Filter</label>
                                                            <div class="col-sm-9 col-form-label">
                                                                    <input type="text" placeholder="role:member" name="form_configuration[{{$item}}][parent_filter]" value="{{$formFieldParentFilter}}"  class="form-control parent_filter" >
                                                            </div>
                                                        </div>


                                                        <div class="form-group row  mb-1">
                                                            <label class="col-sm-4 col-form-label">Allow Multiple ? </label>
                                                            <div class="col-sm-4 col-form-label">
                                                                <label class="fancy-radio">
                                                                    <input type="checkbox" name="form_configuration[{{$item}}][allow_multiple]" {{$formFieldAllowMultiple}} > YES
                                                                </label>
                                                            </div>
                                                        </div>                                                       


                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <a href="javascript:void(0)" class="btn btn-primary" data-bs-dismiss="modal">Save changes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </td>

                                <td><a class="trigger_bars" href="javascript:void(0)"><i data-bs-toggle="modal" data-bs-target="{{'#optionModal_'.$item}}" class="fa fa-bars"></i></a></td>

                                <td>
                                    <div class="form-group">
                                        <input type="text" name="form_configuration[{{$item}}][validation]" value="{{$formFieldValidation}}"  class="form-control" placeholder="required | unique:posts">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <label class="fancy-radio">
                                            <input type="checkbox" name="form_configuration[{{$item}}][searchable]" {{$formFieldSearchable}} >
                                            <span><i></i>Searchable</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label class="fancy-radio">
                                            <input type="checkbox"name="form_configuration[{{$item}}][filterable]" {{$formFieldFilterable}} >
                                            <span><i></i>Filterable</span>
                                        </label>
                                    </div>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="nav-permission" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>SL</td>
                                    <td>User Group</td>
                                    <td title="Warning! When you check self data you must need to fill selfdata_field_name field in this module. Otherwise you may face fatal error" >Self Data <i class="fa fa-info-circle"></i></td>
                                    <td>View</td>
                                    <td>Create</td>
                                    <td>Update</td>
                                    <td>Delete</td>
                                    <td>Import</td>
                                    <td>Export</td>
                                </tr>
                            </thead>
                            <tbody>
                             
                                @foreach(Spatie\Permission\Models\Role::all() as $role)
                                    <tr>
                                        <td>1</td>
                                        <td class="text-uppercase">{{$role->name}}</td>
                                       
                                        <td>
                                            <input type="hidden" name="selfdata[{{$role->name}}]" value="0">
                                            <input type="checkbox" name="selfdata[{{$role->name}}]" value="1"
                                            @php
                                            if($moduleData->selfdata){
                                                $selfdata = (array) json_decode($moduleData->selfdata);
                                                if( array_key_exists($role->name,$selfdata)){
                                                    if($selfdata[$role->name] == 1) echo 'checked';
                                                }
                                            }
                                            @endphp
                                            >
                                        </td>

                                        <td>
                                            <input type="hidden" name="permission[{{$role->name}}][{{$moduleData->permission_title.'.view'}}]" value="0">
                                            <input type="checkbox" 
                                                name="permission[{{$role->name}}][{{$moduleData->permission_title.'.view'}}]"
                                                value="1"
                                                @if($role->hasPermissionTo($moduleData->permission_title.'.view')) checked @endif
                                                @if($role->name == 'superadmin') disabled @endif
                                            >
                                        </td>
                                        <td>
                                            <input type="hidden" name="permission[{{$role->name}}][{{$moduleData->permission_title.'.create'}}]" value="0">
                                            <input type="checkbox" 
                                                name="permission[{{$role->name}}][{{$moduleData->permission_title.'.create'}}]"
                                                value="1"
                                                @if($role->hasPermissionTo($moduleData->permission_title.'.create')) checked @endif
                                                @if($role->name == 'superadmin') disabled @endif
                                            >
                                        </td>
                                        <td>
                                            <input type="hidden" name="permission[{{$role->name}}][{{$moduleData->permission_title.'.update'}}]" value="0">
                                            <input type="checkbox" 
                                                name="permission[{{$role->name}}][{{$moduleData->permission_title.'.update'}}]"
                                                value="1"
                                                @if($role->hasPermissionTo($moduleData->permission_title.'.update')) checked @endif
                                                @if($role->name == 'superadmin') disabled @endif
                                            >
                                        </td>
                                        <td>
                                            <input type="hidden" name="permission[{{$role->name}}][{{$moduleData->permission_title.'.delete'}}]" value="0">
                                            <input type="checkbox" 
                                                name="permission[{{$role->name}}][{{$moduleData->permission_title.'.delete'}}]"
                                                value="1"
                                                @if($role->hasPermissionTo($moduleData->permission_title.'.delete')) checked @endif
                                                @if($role->name == 'superadmin') disabled @endif
                                            >
                                        </td>

                                        <td>
                                            <input type="hidden" name="permission[{{$role->name}}][{{$moduleData->permission_title.'.import'}}]" value="0">
                                            <input type="checkbox" 
                                                name="permission[{{$role->name}}][{{$moduleData->permission_title.'.import'}}]"
                                                value="1"
                                                @if($role->hasPermissionTo($moduleData->permission_title.'.import')) checked @endif
                                                @if($role->name == 'superadmin') disabled @endif
                                            >
                                        </td>

                                        <td>
                                            <input type="hidden" name="permission[{{$role->name}}][{{$moduleData->permission_title.'.export'}}]" value="0">
                                            <input type="checkbox" 
                                                name="permission[{{$role->name}}][{{$moduleData->permission_title.'.export'}}]"
                                                value="1"
                                                @if($role->hasPermissionTo($moduleData->permission_title.'.export')) checked @endif
                                                @if($role->name == 'superadmin') disabled @endif
                                            >
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-builder" role="tabpanel">
                    
                    
                    <p class="text-center p-5">
                        @if($moduleData->status == 1)
                        <a  class="btn btn-danger text-white" onclick="event.preventDefault(); document.getElementById('build-form').submit();"><i class="fa fa-cogs"></i> Build All Codes</a>
                        @else
                        <i class="text-danger">Warning! This Module is not activated for rebuilding. That means it may have a custom code structure.  Please get a backup first and enable it to rebuild.</i>
                        @endif
                    </p>


                </div>

            </div>


        </div>


    </div>

    <div class="form-group mb-4 text-right">
       <p class="text-end"><button type="submit" class="btn btn-primary">Update Module</button></p>
    </div>
</form>

        <form id="build-form" action="{{route('module.build',$moduleData->id)}}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
</div>

@endsection

@push('script')
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script>

<script>
   

    jQuery(document).on('click','.trigger_data_type',function(){
        if(jQuery(this).val() == 'database'){
            jQuery(this).closest('.dynamicHtml').find('.section_database_data').show();
            jQuery(this).closest('.dynamicHtml').find('.section_custom_data').hide();
        }else{
            jQuery(this).closest('.dynamicHtml').find('.section_database_data').hide();
            jQuery(this).closest('.dynamicHtml').find('.section_custom_data').show();
        }

    });

    jQuery(document).on('click','.clone_button',function(){
        var item = jQuery(this).attr('data-item-name');
        var count = jQuery(this).attr('data-count-number');
        var html = '<div class="row cloned_item"><div class="col-sm-3 col-form-label"><p class="text-end"><i class=" delete_item text-danger fa fa-trash"></i></p></div><div class="col-sm-9 col-form-label">'+
            '<label class="fancy-radio" style="width:48%;float: left;margin-right: 3px;">'+
                '<input type="text" name="form_configuration['+item+'][custom_data]['+count+'][name]" placeholder="Name" class="form-control">'+
            '</label>'+
            '<label class="fancy-radio" style="width:48%;float: left;">'+
                '<input type="text" name="form_configuration['+item+'][custom_data]['+count+'][value]" placeholder="Value" class="form-control">'+
            '</label>'+
        '</div> </div>';
        var modalId = jQuery(this).attr('data-modal-id');
        jQuery('#'+modalId+' .parent_clone_section').append(html);
        
        count = Number(count)+1;
        jQuery(this).attr('data-count-number',count)
    })

    jQuery(document).on('click','.delete_item',function(){
        jQuery(this).closest('.cloned_item').remove();
    });

    jQuery(document).on('change','.database_table_trigger',function(){
        var that = jQuery(this);
        jQuery.ajax({
            url: "/core/database-columns/"+jQuery(this).find('option:selected').val(),
            cache: false,
            success: function(response){
                that.closest('.section_database_data').find(".relationKey").html(response);
                that.closest('.section_database_data').find(".display1").html(response);
                that.closest('.section_database_data').find(".display2").html(response);
                that.closest('.section_database_data').find(".display3").html(response);
            }
        });
    });



    jQuery(document).on('click','.trigger_option',function(){
        var selected = jQuery(this).find('option:selected').val();
        if(selected == 'radio' || selected == 'checkbox' || selected == 'select'){
            jQuery(this).closest('tr').find('.trigger_bars').show();
        }else{
            jQuery(this).closest('tr').find('.trigger_bars').hide();
        }
    });


    jQuery(document).ready(function(){


        jQuery('.trigger_option').each(function(key,val){
            var selected = jQuery(this).find('option:selected').val();
            if(selected == 'radio' || selected == 'checkbox' || selected == 'select'){
                jQuery(this).closest('tr').find('.trigger_bars').show();
            }
        });


        jQuery('.dynamicHtml').each(function(key,val){
            if(jQuery(this).find('.trigger_data_type:checked').val() == 'database'){
                jQuery(this).find('.section_database_data').show();
                jQuery(this).find('.section_custom_data').hide();
            }else{
                jQuery(this).find('.section_database_data').hide();
                jQuery(this).find('.section_custom_data').show();
            }
        });


        jQuery('.database_table_trigger').each(function(key,val){
            var dbName =jQuery(this).find('option:selected').val();
            var that = jQuery(this);
            jQuery.ajax({
                url: "/core/database-columns/"+dbName,
                cache: false,
                success: function(response){
                    that.closest('.section_database_data').find(".relationKey").html(response);
                    that.closest('.section_database_data').find(".display1").html(response);
                    that.closest('.section_database_data').find(".display2").html(response);
                    that.closest('.section_database_data').find(".display3").html(response);

                    var selectedrelationKey = that.closest('.section_database_data').find(".relationKey").attr('data-selected-value');
                    that.closest('.section_database_data').find('.relationKey option[value="'+selectedrelationKey+'"]').prop('selected', true);

                    var selectedDisplay1 = that.closest('.section_database_data').find(".display1").attr('data-selected-value');
                    that.closest('.section_database_data').find('.display1 option[value="'+selectedDisplay1+'"]').prop('selected', true);

                    var selectedDisplay2 = that.closest('.section_database_data').find(".display2").attr('data-selected-value');
                    that.closest('.section_database_data').find('.display2 option[value="'+selectedDisplay2+'"]').prop('selected', true);

                    var selectedDisplay3 = that.closest('.section_database_data').find(".display3").attr('data-selected-value');
                    that.closest('.section_database_data').find('.display3 option[value="'+selectedDisplay3+'"]').prop('selected', true);
                }
            });
        })
    });


</script>
@endpush