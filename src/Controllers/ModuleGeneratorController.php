<?php

namespace Concaveit\ModuleGenerator\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Concaveit\Modulegenerator\ModuleGenerator;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Auth;

class ModuleGeneratorController extends Controller
{

    public function __construct(){
        $this->middleware(function($request,$next){
            $this->user = Auth::user();
            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ModuleGenerator::all();
        return view('concaveit_modulegenerator::core.module.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = \DB::select('SHOW TABLES');
        return view('concaveit_modulegenerator::core.module.create',compact('tables')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $reservedTitles = ['user','modulegenerator'];

        if(in_array(strtolower($request->controller_name),$reservedTitles )){
            return back()->with('error','Invalid controller name. Reserved controller names are '.implode(',',$reservedTitles));
        }

        $validated = $request->validate([
            'module_title' => 'required',
            'controller_name' => 'required | unique:module_generators',
            'database_table_name' => 'required',
            'permission_title' => 'required | unique:module_generators',
            'grid_table_type' => 'required',
        ]);

       
        $model = new ModuleGenerator();

        $model->module_title = $request->module_title;
        $model->module_description = $request->module_description;
        $model->controller_name = preg_replace('/\s+/', '', trim($request->controller_name));
        $model->database_table_name = $request->database_table_name;
        $model->grid_table_type = $request->grid_table_type;
        $model->permission_title = preg_replace('/\s+/', '', trim($request->permission_title));
        $model->configuration = '';
        $model->status = $request->status;
        $model->softdelete = ($request->softdelete) ? 1 : 0;
        $update = $model->save();

        //Create Permissions
        $permissions = [
            $model->permission_title.'.view',
            $model->permission_title.'.create',
            $model->permission_title.'.update',
            $model->permission_title.'.delete',
            $model->permission_title.'.export',
            $model->permission_title.'.import',
        ];

        $RoleSuperAdmin = Role::findOrCreate('superadmin','web');

        foreach($permissions as $permission){
            $permission = Permission::findOrCreate($permission,'web');
            $RoleSuperAdmin->givePermissionTo($permission);
            $permission->assignRole($RoleSuperAdmin);
        }

        if($update) {
            $this->createRouters();
            return redirect()->route('concaveit_modulegenerator::module.edit',$model->id)->with('success', 'Module has been created. Please configure table and form settings and build the module!');
        }else {
            return back()->with('error','Something went wrong!');
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModuleGenerator  $moduleGenerator
     * @return \Illuminate\Http\Response
     */
    public function show(ModuleGenerator $moduleGenerator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModuleGenerator  $moduleGenerator
     * @return \Illuminate\Http\Response
     */
    public function edit(ModuleGenerator $moduleGenerator,$id)
    {

        $moduleData = $moduleGenerator::find($id);
        $columns = $moduleGenerator->getTableColumns($moduleData->database_table_name);
        $tables = \DB::select('SHOW TABLES');
        return view('concaveit_modulegenerator::core.module.update',compact('moduleData','columns','tables')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModuleGenerator  $moduleGenerator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModuleGenerator $moduleGenerator,$id)
    {
        $validated = $request->validate([
            'module_title' => 'required',
            'form_configuration' => 'required',
            'table_configuration' => 'required',
            'grid_table_type' => 'required',
        ]);

        $model = $moduleGenerator->find($id);
        $model->module_title = $request->module_title;
        $model->module_description = $request->module_description;
        $model->grid_table_type = $request->grid_table_type;
        $model->softdelete = ($request->softdelete) ? 1 : 0;
        $model->status = ($request->status) ? 1 : 0;

        $model->selfdata_field_name = $request->selfdata_field_name ?? null;
        $model->selfdata = ($request->selfdata) ? json_encode($request->selfdata) : null;



        $model->configuration =  json_encode([
            'table_configuration' => $request->table_configuration,
            'form_configuration' => $request->form_configuration
        ]);

        $update = $model->save();

        //Update Permissions
        $allPermissions = $request->permission;

        foreach($allPermissions as $role => $permissions ){
            if($role != 'superadmin'){
                $role = Role::findOrCreate($role,'web');
                foreach($permissions as $permission => $val){
                    if($val == 1){
                        //Create or update permissions
                        $permission = Permission::findOrCreate($permission,'web');
                        $role->givePermissionTo($permission);
                        $permission->assignRole($role);
                    }else{
                        //Revoke permission
                        $role->revokePermissionTo($permission);
                    }
                }
            }

        }


        if($update) session()->flash('success','Module has been updated!');
        else session()->flash('error','Something went wrong!');
        return back();
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModuleGenerator  $moduleGenerator
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(is_null($this->user) || !$this->user->can('module.delete')){
            return redirect()->route('dashboard')->with('error', 'You don\'t have enough privileges to perform this action!');
        }

		$module = ModuleGenerator::find($id);
        $viewDirName = strtolower($module->controller_name);
        $controllerName = $module->controller_name;
        $modelName = $module->controller_name;
		
        $dirView = base_path().'/resources/views/'.$viewDirName;
        File::deleteDirectory($dirView);

        $controllerFile = app_path().'/Http/Controllers/'.$controllerName.'Controller.php';
        File::delete($controllerFile);

        $apiControllerFile = app_path().'/Http/Controllers/Api/'.$controllerName.'Controller.php';
        File::delete($apiControllerFile);

        $modelFile = app_path().'/Models/'.$modelName.'.php';
        File::delete($modelFile);

        $update = $module->delete();

		if($update){
			return back()->with('success', 'Record has been successfully deleted!');
		}else{
			return back()->with('error', 'Unable to delete this record!');
		}
    }

     /**
     * buildModule the specified resource from storage.
     *
     * @param  \App\Models\ModuleGenerator  $moduleGenerator
     * @return \Illuminate\Http\Response
     */
    public function buildModule(Request $request, ModuleGenerator $moduleGenerator,$id){
        $module = $moduleGenerator::find($id);

        if($module &&  $module->status == 1){
            $class =  strtolower($module->controller_name);
            $dir = base_path().'/resources/views/'.$class; 
            $dirC = app_path().'/Http/Controllers/';
            $dirApi = app_path().'/Http/Controllers/Api/';
            $dirM = app_path().'/Models/';
            $ctr = ucwords($module->controller_name);

            if(!is_dir($dir)) mkdir( $dir,0777 );  

            $f = '';
            $req = '';


            $codes = [
                'controller'            => ucwords($class),
                'class'                 => $class,
                'table'                 => $module->database_table_name ,
                'title'                 => $module->module_title ,
                'note'                  => $module->module_description,
                'permission_title'      => $module->permission_title,
                'selfdata'              => $module->selfdata,
                'selfdata_field_name'   => $module->selfdata_field_name,
                'softdelete'            => ($module->softdelete) ? 'use SoftDeletes; protected $softDelete = true;' : '',
            ];

            $codes['form_html'] = \Helper::generateForm($module->configuration);
            $codes['script_html'] = \Helper::generateScript($module->configuration);

            $mType = ( $module->grid_table_type == 'native' ? 'native' :  $module->grid_table_type);

                if( $mType == 'datatable')  $codes['datatable_cols'] = \Helper::formatDataTableItem(ucwords($class));

                if(is_dir( base_path().'/resources/views/core/template/'.$mType )){
                    require_once( base_path().'/resources/views/core/template/'.$mType.'/config/config.php');
                }else {
                    if($request->ajax() == true && \Auth::check() == true){
                        return response()->json(array('status'=>'success','message'=>'Template does not exists!')); 
                    } else {
                        return redirect('concave/module')->with('message','Template does not exists!')->with('status','success');   
                    }  
                } 

            self::createRouters($module->id);
        
            if($request->ajax() == true && \Auth::check() == true){
                return response()->json(array('status'=>'success','message'=>'Module has been build successfully!')); 
            } else {
                session()->flash('success','Module has been build successfully!');
                return back();
            }
        }else{
            return back()->with('error', 'Module can not build because it is not enabled or not found!');
        }




        
    }

    /**
     * createRouters the specified resource from function.
     *
     * @param  \App\Models\ModuleGenerator  $moduleGenerator
     * @return \Illuminate\Http\Response
     */


    public function createRouters(){
        $modules = ModuleGenerator::all();
        $val  =    "<?php";
        $val_api  = "<?php"; 
    
        foreach($modules as $module){
            $route =  strtolower($module->controller_name);
            $controller = ucwords($module->controller_name).'Controller';
            $mType = ( $module->grid_table_type == 'native' ? 'native' :  $module->grid_table_type);
            include(base_path().'/resources/views/core/template/'.$mType.'/config/route.php' );
            include(base_path().'/resources/views/core/template/'.$mType.'/config/route_api.php' ); 
        }

        $val .=     "?>";
        $val_api .=     "?>";

        $filename = base_path().'/routes/module.php';
        $fp=fopen($filename,"w+"); 
        fwrite($fp,$val); 
        fclose($fp);    
        file_put_contents( base_path()."/routes/services.php" , $val_api) ;
        return true;
    }

    public function getDatabaseColumns(ModuleGenerator  $moduleGenerator,$databasename){
        $html = '<option value="">-- Select Field -- </option>';
        if($databasename != -1 ){
            foreach($moduleGenerator->getTableColumns($databasename) as $column){
                $html .= '<option value="'.$column.'">'.$column.'</option>';
            }
        }
        return $html;
    }


    public function getDatabaseRelationOptions(Request $request){
        return \Helper::getSlelectDatabaseValues($request->db,$request->key,$request->display1,$request->display2,$request->display3,$request->parent_filter);
    }

    public function createMigration(){
        return view('concaveit_modulegenerator::core.module.create-migration'); 
    }



    public function generateMigration(Request $request){

       $request->validate([
            'table_name' => 'required',
        ]);

        $codes = [];
        $tableClass = '';
        $migrationSting = '';

        $table_name =  $request->table_name;
        
        if(Schema::hasTable($table_name)){
            return back()->with('error','Table already exists! Please try with another table name!');
        }


        $codes['table_name'] = $table_name;
        $explodeTableName = explode('_',$table_name);
        foreach($explodeTableName as $tbName){
            $tableClass.= ucwords($tbName);
        }

        $codes['table_class'] = 'Create'.$tableClass.'Table';

        
        $softDelete = ($request->softdelete) ? true : false;

        foreach($request->table as $key => $val){

            if(isset($val['data_type']) && $val['data_type'] == 'id'){
                $migrationSting.= '$table->id();';
            }else{

                if(isset($val['auto_increment'])){
                    $migrationSting.= '$table->increments("'.$val['column_name'].'");';
                }else{
                    $part = '';

                    if(isset($val['default_value'])){
                        $part.= '->default("'.$val['default_value'].'")';
                    }
    
                    if(!isset($val['not_null'])){
                        $part.= '->nullable()';
                    }

                    if(isset($val['data_length'])){
                        $migrationSting.= '$table->'.$val['data_type'].'("'.$val['column_name'].'",'.$val['data_length'].')'.$part.';';
                    }else{
                        $migrationSting.= '$table->'.$val['data_type'].'("'.$val['column_name'].'")'.$part.';';
                    }

                }

            }
        }


        if($softDelete){
            $migrationSting.= '$table->softDeletes();';
        }

        $migrationSting.= '$table->timestamps();';
        $codes['migration'] = $migrationSting;
        $template = base_path().'/resources/views/core/template/native/';
        $migration = file_get_contents(  $template.'migration.tpl' );
        $build_migration = \Helper::blend($migration,$codes);   
        $migrationPath = database_path('migrations');
        $migrationFile = $migrationPath.'/'.date('Y_m_d_his').'_create_'.$table_name.'_table.php';
        
        file_put_contents($migrationFile, $build_migration);

        try {
			\Artisan::call('migrate');
            return back()->with('success','Table has been created successfully!');
		}
		catch(\Exception $e) {
            File::delete($migrationFile);
            return back()->with('error','Table could not created. Because of invalid migration format!');
		}

        

        

    }


}
