@extends('layouts.app')
@section('content')

	<div class="body d-flex py-lg-3 py-md-2">
	    <div class="container-xxl">

			<div class="row align-items-center">
				<div class="border-0 mb-4">
					<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
						<h3 class="fw-bold mb-0">Menu Manage</h3>
					</div>
				</div>
			</div>

			<div class="toolbar-nav">
			    <div class="btn-group">
					<a href="{{ url('core/sidemenu-bulk-create')}}" class="btn  btn-sm btn-danger text-white"> <i class="fa fa-plus"></i> Bulk Create </a>
			    	<a href="{{ url('core/sidemenu/create')}}" class="btn  btn-sm btn-primary @if(is_null(request()->pos)) menu_active @endif"> <i class="fa fa-plus"></i> New Menu </a>
			        <a href="{{ url('core/sidemenu/create/?pos=top')}}" class="btn  btn-sm btn-info text-white @if(request()->pos == 'top') menu_active @endif"> <i class="fa fa-bars"></i> Top Menu  </a>
			        <a href="{{  url('core/sidemenu/create/?pos=sidebar') }}" class="btn  btn-sm btn-success post_url text-white @if(request()->pos == 'sidebar') menu_active @endif"> <i class="fa fa-bars"></i> Admin Menu </a>
			    </div>
			</div>


			<div class="sbox-content">
				<div class="row">	
					<div class="col-md-5" >
						<fieldset style="min-height: 400px;">
							<legend> Menu Navigation <small style="font-size: 11px;" class="text-danger"> Note! Menus only support 3 levels</small></legend>
							
							<div id="list2" class="dd myadmin-dd-empty " style="min-height:350px;">
					            <ol class="dd-list">
									@foreach ($results as $menu)
									  	<li data-id="{{$menu['menu_id']}}" class="dd-item dd3-item">
											<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu['menu_name']}}
												<span class="pull-right">
												<a href="{{ url('core/sidemenu/edit/'.$menu['menu_id'].'?pos='.$active)}}" class="text-info"><i class="icofont-edit"></i></a></span>
											</div>
											@if(count($menu->submenues) > 0)
											<ol class="dd-list" style="">
												@foreach ($menu->submenues as $menu2)
												 	<li data-id="{{$menu2['menu_id']}}" class="dd-item dd3-item">
														<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu2['menu_name']}}
															<span class="pull-right">
															<a href="{{ url('core/sidemenu/edit/'.$menu2['menu_id'].'?pos='.$active)}}" class="text-info"><i class="icofont-edit"></i></a></span>
														</div>
														@if(count($menu2->submenues) > 0)
															<ol class="dd-list" style="">
																@foreach($menu2->submenues as $menu3)
														 			<li data-id="{{$menu3['menu_id']}}" class="dd-item dd3-item">
																		<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{ $menu3['menu_name'] }}
																			<span class="pull-right">
																			<a href="{{ url('core/sidemenu/edit/'.$menu3['menu_id'].'?pos='.$active)}}" class="text-info"><i class="icofont-edit"></i></a>
																			</span>
																		</div>
																	</li>	
																@endforeach
															</ol>
														@endif
													</li>							
												@endforeach
											</ol>
											@endif
										</li>
									@endforeach			  
					            </ol>
					        </div>
							{!! Form::open(array('url'=>'core/menu/saveorder', 'class'=>'form-horizontal','files' => true)) !!}	
								<input type="hidden" name="reorder" id="reorder" value="" />	
								<button type="submit" class="btn btn-primary btn-sm ">Reorder Menu</button>	
							{!! Form::close() !!}	
						</fieldset>
					</div>	

					<div class="col-md-7 card">
						<fieldset style="min-height: 400px;" class="card-body">
							<legend> Create / Update</legend>
		 					{!! Form::open(array('url'=>'core/menu/save', 'class'=>'form-horizontal','files' => true  , 'parsley-validate'=>'','novalidate'=>' ')) !!}
								<input type="hidden" name="menu_id" id="menu_id" value="{{ $row['menu_id'] ?? '' }}" />

								<input type="hidden" name="parent_id" id="parent_id" value="{{ $row['parent_id'] ?? '' }}" />	
							  	<div class="form-group row mb-2">
									<label for="ipt" class=" control-label col-md-4 text-right">Name / Title</label>
									<div class="col-md-8">
								  		{!! Form::text('menu_name', $row['menu_name'],array('class'=>'form-control form-control-sm ', 'placeholder'=>'','required'=>'true')) !!} 
								 	</div> 
							  	</div> 

								<div class="form-group row mb-2" >
									<label for="ipt" class=" control-label col-md-4 text-right"> Menu Type</label> 
									<div class="col-md-8 menutype">
										<input type="radio" name="menu_type" value="internal" class="minimal-green"   required="true" 
										@if($row['menu_type']=='internal' || $row['menu_type']=='') checked="checked" @endif id="l-internal" />
									
										<label for="l-internal"> Internal </label>
									
										<input type="radio" name="menu_type" value="external"  class="minimal-green" required="true" 

										@if($row['menu_type']=='external' ) checked="checked" @endif  id="l-external" /> <label for="l-external"> External </label> 
									  
									</div> 
								</div> 
 					
								<div class="form-group row  ext-link mb-2" >
									<label for="ipt" class=" control-label col-md-4 text-right"> Url  </label>
									<div class="col-md-8">
									   {!! Form::text('url', $row['url'],array('class'=>'form-control form-control-sm', 'placeholder'=>' Type External Url')) !!} 
									 </div> 
								</div>

							  	<div class="form-group row  int-link mb-2" >
									<label for="ipt" class=" control-label col-md-4 text-right"> Controller / Route  </label>
									<div class="col-md-8">
								 		
								
										<select name='module' rows='5' id='module'  style="width:100%" 
										class="select2">
											<option value=""> -- Select Module or Page -- </option>
											<option value="separator" @if($row['module']== 'separator' ) selected="selected" @endif> Separator Menu </option>
											<optgroup label="Module ">
											@foreach($modules as $mod)
												<option value="{{ strtolower($mod->controller_name) }}"
												@if($row['module']== strtolower($mod->controller_name)) selected="selected" @endif
												>{{ $mod->module_title}}</option>
											@endforeach
											</optgroup>					
										</select> 
								 	</div> 
							  	</div> 										
							
								<div class="form-group row  mb-2" >
									<label for="ipt" class=" control-label col-md-4 text-right">Position</label>
									<div class="col-md-8">
										<div class="">
											<input type="radio" name="position"  value="top" required  class="minimal-green" 
											@if($row['position']=='top' ) checked="checked" @endif  id="l-top"/> 
											<label for="l-top"> Top Menu </label>
										</div>
										<div class="">	
											<input type="radio" name="position"  value="sidebar"  required class="minimal-green" 
											@if($row['position']=='sidebar' ) checked="checked" @endif  id="l-sidebar" />
											 <label for="l-sidebar">Admin Menu</label>
										</div>	
									</div> 
								</div> 	

								<div class="form-group row mb-2" >
									<label for="ipt" class=" control-label col-md-4 text-right">Icon Class</label>
									<div class="col-md-8">
									  	{!! Form::text('menu_icons', $row['menu_icons'],array('class'=>'form-control form-control-sm', 'placeholder'=>'')) !!}
								  		<p>Example : <span class="icofont-cow-head"> icofont-cow-head </span> </p>
								  		<p> View Icon Codes : 
								  		<a href="{{ url('core/menu/icon')}}" class="text-info" onclick="ConcaveModal(this.href,'Select Icon'); return false;"> Browse Icons  </a>  
									</div> 
								</div>

								<div class="form-group row mb-2 " >
									<label for="ipt" class=" control-label col-md-4 text-right"> Active</label>
									<div class="col-md-8 ">
										<div class="">
											<input type="radio" name="active"  value="1"  class="minimal-green" 
											@if($row['active']=='1' ) checked="checked" @endif id="l-1" /> 

											<label for="l-1">Active</label>
										</div>
										<div class="">
											<input type="radio" name="active" value="0"  class="minimal-green" 
											@if($row['active']=='0' ) checked="checked" @endif id="l-2" /> 
											<label for="l-2"> Inactive </label>
										</div>	
									</div> 
								</div> 

							  	<div class="form-group row mb-2">
									<label for="ipt" class=" control-label col-md-4 text-right">Access <code>*</code></label>
									<div class="col-md-8">
										<?php $pers = json_decode($row['access_data'],true);
										foreach($groups as $group) {
											$checked = '';
											if(isset($pers[$group->name]) && $pers[$group->name]=='1')
											{
												$checked= ' checked="checked"';
											}						
										?>		
										  	<div class="">
										  		<input type="checkbox" name="groups[<?php echo $group->name;?>]" value="<?php echo $group->name;?>" <?php echo $checked;?> class="filled-in" id="a-<?php echo $group->name;?>"  />   
										  		<label for="a-<?php echo $group->name;?>"><?php echo ucfirst($group->name); ?>  </label>
										  	</div>
								  		<?php } ?>
									</div> 
							  	</div> 

								<div class="form-group row  mb-2" >
									<label for="ipt" class=" control-label col-md-4 text-right">Public</label>
									<div class="col-md-8">
										<div class="">
											<input  type='checkbox' name='allow_guest'  class="filled-in" id="all"  
					 						@if($row['allow_guest'] == 1 ) checked  @endif	
										  	value="1"	/> <label for="all">  Yes  </lable>
										</div>   
									</div>
								</div>
						  
							  	<div class="form-group row mb-2">
									<label class="col-sm-4 text-right">&nbsp;</label>
									<div class="col-sm-8">	
										<button type="submit" class="btn btn-primary btn-sm">Submit</button>
										@if($row['menu_id'] !='')
											<button type="button"onclick="ConcaveConfirmDelete('{{ url('core/sidemenu/destroy/'.$row['menu_id'].'?pos='.$active)}}', '{{ url('core/sidemenu/create/?pos='.$active)}}')" class="btn btn-danger btn-sm">  Delete </button>
										@endif	
									</div>	  
							  	</div> 
				 			{!! Form::close() !!}	
						</fieldset>	
					</div>	
				</div>	
			</div>
		</div>
	</div>
@push('script')
	<div class="modal" id="concave-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	    <div class="modal-dialog  modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="exampleModalLabel1">New message</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            </div>
	            <div class="modal-body" id="concave-modal-content">
	                
	            </div>
	           
	        </div>
	    </div>
	</div>
	<script type="text/javascript" src="{{ asset('assets/js/jquery.nestable.js') }}"></script>
	<script>
	    $(document).ready(function()
		{
		    $('.dd').nestable();
		    update_out('#list2',"#reorder");
		    
		    $('#list2').on('change', function() {
				var out = $('#list2').nestable('serialize');
				$('#reorder').val(JSON.stringify(out));	  

		    });
			$('.ext-link').hide(); 

			$('.menutype input:radio').on('click', function() {
			 	 val = $(this).val();
		  			mType(val);
			  
			});
			
			mType(); 
		});

		function mType( val )
		{
				if(val == 'external') {
					$('.ext-link').show(); 
					$('.int-link').hide();
				} else {
					$('.ext-link').hide(); 
					$('.int-link').show();
				}	
		}

			
		function update_out(selector, sel2){
			
			var out = $(selector).nestable('serialize');
			$(sel2).val(JSON.stringify(out));

		}

		function ConcaveModal( url , title)
		{
			
			$('#concave-modal-content').html(' ....Loading content , please wait ...');
			$('.modal-title').html(title);
			$('#concave-modal-content').load(url,function(){
			});
			$('#concave-modal').modal('show');	
		}

		function ConcaveDelete(  )
		{	
			var total = $('input[class="ids"]:checkbox:checked').length;
			Swal.fire({
		        title: 'Confirm ?',
		        text: ' Are u sure deleting this record ? ',
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonText: 'Yes, please',
		        cancelButtonText: 'cancel'
		      }).then((result) => {
		        if (result.value) {
		         	$('input[name="action_task"]').val('delete');
					$('#ConcaveTable').submit();// do the rest here
		        }
		      })
		}

		function ConcaveConfirmDelete( url, lodurl )
		{

			Swal.fire({
		        title: 'Confirm ?',
		        text: ' Are u sure deleting this record ? ',
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonText: 'Yes, please',
		        cancelButtonText: 'cancel'
		      }).then((result) => {
		        if (result.value) {
		          	window.location.href = url;
		        }
		      })

			return false;
		}
	</script>
@endpush
@endsection

