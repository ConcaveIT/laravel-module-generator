@extends('layouts.app')

@section('content')

	<div class="card">
		<div class="card-body">
		@if(isset($data))
			<form action="{{route('sidemenu.update',$data->id)}}" method="post">
			@method('put')
		@else
			<form action="{{route('sidemenu.store')}}" method="post">
		@endif
			@csrf
				<div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Parent id  </label>
							<div class="col-sm-9">
								<select  data-selected-value="{{$data->parent_id ?? "" }}" id="select_parent_id"  data-live-search="true" data-select-type=""  class="form-control select2 @error("parent_id") is-invalid @enderror" name="parent_id" ></select>
								
								@error("parent_id")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Module  </label>
							<div class="col-sm-9">
								<select  data-selected-value="{{$data->module ?? "" }}" id="select_module"  data-live-search="true" data-select-type=""  class="form-control select2 @error("module") is-invalid @enderror" name="module" ></select>
								
								@error("module")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Title  </label>
							<div class="col-sm-9">
								<input type="text" name="title"  class="form-control @error("title") is-invalid @enderror" value="{{$data->title ?? "" }}" >
								@error("title")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Menu type  </label>
							<div class="col-sm-9">
								<select  data-selected-value="{{$data->menu_type ?? "" }}" id="select_menu_type"  data-live-search="true" data-select-type=""  class="form-control select2 @error("menu_type") is-invalid @enderror" name="menu_type" ></select>
								
								@error("menu_type")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">External link  </label>
							<div class="col-sm-9">
								<input type="text" name="external_link"  class="form-control @error("external_link") is-invalid @enderror" value="{{$data->external_link ?? "" }}" >
								@error("external_link")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Sort order  </label>
							<div class="col-sm-9">
								<input type="number" name="sort_order"  class="form-control @error("sort_order") is-invalid @enderror" value="{{$data->sort_order ?? "" }}" >
								@error("sort_order")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Menu icon  </label>
							<div class="col-sm-9">
								<input type="text" name="menu_icon"  class="form-control @error("menu_icon") is-invalid @enderror" value="{{$data->menu_icon ?? "" }}" >
								@error("menu_icon")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>
			</div><div class="row g-3 align-items-center">
					<div class="col-md-12">
						<div class="form-group row  mb-1">
							<label for="ModuleTitle" class="col-sm-3 col-form-label">Permission title  </label>
							<div class="col-sm-9">
								<select multiple data-selected-value="{{$data->permission_title ?? "" }}" id="select_permission_title"  data-live-search="true" data-select-type="multiple"  class="form-control select2 @error("permission_title") is-invalid @enderror" name="permission_title[]" ></select>
								
								@error("permission_title")
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							
						</div>
					</div>
			</div>
				<div class="form-group mb-4 mt-4 text-right">
					<p class="text-end"><button type="submit" class="btn btn-primary">Save Information</button></p>
				 </div>
			</form>
		</div>
	</div>
		 
@endsection

@push('script')
<script>
							jQuery(document).ready(function(){
								jQuery.ajax({
									url: "{{route("database.relation.options")}}?db=menu&key=id&display1=title&display2=&display3=",
									success: function(response){
										jQuery("#select_parent_id").html(response);
										var selectedVal = jQuery("#select_parent_id").attr("data-selected-value");
	
										if(jQuery("#select_parent_id").attr("data-select-type") == "multiple"){
											var str_array = selectedVal.split(",");
											for(var i = 0; i < str_array.length; i++) {
											str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
												jQuery("#select_parent_id").find("option[value="+str_array[i]+"]").prop("selected", true);
											}
										}else{
											jQuery("#select_parent_id").find("option[value="+selectedVal+"]").prop("selected", true);
										}
									}
								});
							});
						
						</script><script>
							jQuery(document).ready(function(){
								jQuery.ajax({
									url: "{{route("database.relation.options")}}?db=module_generators&key=id&display1=module_title&display2=&display3=",
									success: function(response){
										jQuery("#select_module").html(response);
										var selectedVal = jQuery("#select_module").attr("data-selected-value");
	
										if(jQuery("#select_module").attr("data-select-type") == "multiple"){
											var str_array = selectedVal.split(",");
											for(var i = 0; i < str_array.length; i++) {
											str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
												jQuery("#select_module").find("option[value="+str_array[i]+"]").prop("selected", true);
											}
										}else{
											jQuery("#select_module").find("option[value="+selectedVal+"]").prop("selected", true);
										}
									}
								});
							});
						
						</script><script>
							jQuery(document).ready(function(){
								jQuery("#select_menu_type").html("<option value='internal'>internal</option><option value='external'>external</option>");
								var selectedVal = jQuery("#select_menu_type").attr("data-selected-value");
								if(jQuery("#select_menu_type").attr("data-select-type") == "multiple"){
									var str_array = selectedVal.split(",");
									for(var i = 0; i < str_array.length; i++) {
									str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
										jQuery("#select_menu_type").find("option[value="+str_array[i]+"]").prop("selected", true);
									}
								}else{
									jQuery("#select_menu_type").find("option[value="+selectedVal+"]").prop("selected", true);
								}
							});
						
						</script><script>
							jQuery(document).ready(function(){
								jQuery.ajax({
									url: "{{route("database.relation.options")}}?db=roles&key=id&display1=name&display2=&display3=",
									success: function(response){
										jQuery("#select_permission_title").html(response);
										var selectedVal = jQuery("#select_permission_title").attr("data-selected-value");
	
										if(jQuery("#select_permission_title").attr("data-select-type") == "multiple"){
											var str_array = selectedVal.split(",");
											for(var i = 0; i < str_array.length; i++) {
											str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
												jQuery("#select_permission_title").find("option[value="+str_array[i]+"]").prop("selected", true);
											}
										}else{
											jQuery("#select_permission_title").find("option[value="+selectedVal+"]").prop("selected", true);
										}
									}
								});
							});
						
						</script>
@endpush