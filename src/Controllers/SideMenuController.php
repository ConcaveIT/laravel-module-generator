<?php 
namespace Concaveit\ModuleGenerator\Controllers;
use Concaveit\Modulegenerator\Sidemenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Concaveit\Modulegenerator\ModuleGenerator;
use Validator, Input, Redirect, Auth; 
use Spatie\Permission\Models\Permission;
use DB;


class SidemenuController extends Controller {

	const MESSAGE = 'You don\'t have enough privileges to perform this action!';
	
	public function __construct(){
        $this->middleware(function($request,$next){
            $this->user = Auth::user();
			$this->role = Role::findByName('superadmin');
			$this->model = new Sidemenu();
            return $next($request);
        });

    }

	

	public function index( Request $request ){
	
		if(is_null($this->user)){
            return redirect()->route('dashboard')->with('error',self::MESSAGE);
        }

		$results = Sidemenu::all();
        return view('core.sidemenu.index',compact('results'));
	}
	

	function create( Request $request ,$id = null) {
		if(is_null($this->user)){
            return redirect()->route('dashboard')->with('error', self::MESSAGE);
        }
        $pos = (!is_null($request->input('pos')) ? $request->input('pos') : 'top' );
        $row = DB::table('core_menu')->where('menu_id',$id)->get();
		if(count($row)>=1)
		{
			
			$rows = $row[0];
			$this->data['row'] =  (array) $rows;   
		} else {
			$this->data['row'] = array(
					'menu_id'	=> '',
					'parent_id'	=> '',
					'menu_name'	=> '',
					'menu_type'	=> '',
					'url'	=> '',
					'module'	=> '',
					'position'	=> '',
					'menu_icons'	=> '',
					'active'	=> '',
					'allow_guest'	=> '',
					'access_data'	=> '',

				); 
		}
		if($pos) {
			$this->data['results']		= Sidemenu::where('parent_id','0')->where('position', $pos)->orderBy('ordering','asc')->get();
		}else{
			$this->data['results']		= Sidemenu::where('parent_id','0')->orderBy('ordering','asc')->all();
		}
		$this->data['active'] 		= $pos;
		$this->data['groups'] 		= DB::select("SELECT * FROM roles");
		$this->data['modules'] 		= DB::table('module_generators')->get();

		return view('core.sidemenu.create', $this->data);
	}

	function edit( Request $request , $id ){

		if(is_null($this->user)){
            return redirect()->route('dashboard')->with('error', self::MESSAGE);
        }

        $pos = (!is_null($request->input('pos')) ? $request->input('pos') : 'top' );
        $row = DB::table('core_menu')->where('menu_id',$id)->get();
		if(count($row)>=1)
		{
			$rows = $row[0];
			$this->data['row'] =  (array) $rows;   
		} else {
			$this->data['row'] = array(
					'menu_id'	=> '',
					'parent_id'	=> '',
					'menu_name'	=> '',
					'menu_type'	=> '',
					'url'	=> '',
					'module'	=> '',
					'position'	=> '',
					'menu_icons'	=> '',
					'active'	=> '',
					'allow_guest'	=> '',
					'access_data'	=> '',

				); 
		}
		if($pos) {
			$this->data['results']		= Sidemenu::where('position', $pos)->orderBy('ordering','asc')->get();
		}else{
			$this->data['results']		= Sidemenu::orderBy('ordering','asc')->all();
		}
		$this->data['active'] 		= $pos;
		$this->data['groups'] 		= DB::select("SELECT * FROM roles");
		$this->data['modules'] 		= DB::table('module_generators')->get();

		return view('core.sidemenu.create', $this->data);
	}

	function show( Request $request , $id ) {

		if(is_null($this->user)){
            return redirect()->route('dashboard')->with('error', self::MESSAGE);
        }
	}



	
	function bulkCreate(){

		$modules = ModuleGenerator::select('module_title','controller_name','permission_title')->get();
		$sidemenus = Sidemenu::select('module')->get();

		$allModules = [];
		$allMenus = [];
		$permissions = [];

		foreach($sidemenus as $sidemenu){
			$allMenus[] = $sidemenu->module;
		}

		foreach($modules as $module){
			if(!in_array(strtolower($module->controller_name),$allMenus)){
				$allModules[strtolower($module->controller_name)] = $module->controller_name;
			}

			$permissions[] = $module->permission_title.'.view,';
			$permissions[] = $module->permission_title.'.create,';
			$permissions[] = $module->permission_title.'.update,';
			$permissions[] = $module->permission_title.'.delete,';

		}

		foreach($allModules as $key => $val){
			$menu = new Sidemenu();
			$menu->module = $key;	
			$menu->url = null;	
			$menu->menu_name = $val;	
			$menu->menu_type = 'internal';	
			$menu->position = 'sidebar';	
			$menu->menu_icons = 'icofont-book';	
			$menu->active = 1;	

			$arr = array();
			$groups = \DB::table('roles')->get();
			$arr['superadmin'] = 1;	
			$arr['admin'] = 1;	
			// foreach($groups as $g){
			// 	$arr[$g->name] = (isset($_POST['groups'][$g->name]) ? "1" : "0" );	
			// }

			$menu->access_data = json_encode($arr);		
			$menu->allow_guest = 0;
			$menu->save();
		}



		/** Generate Permissions **/

		//var_dump($permissions); exit;
        $RoleSuperAdmin = Role::findOrCreate('superadmin','web'); //Create Role Supperadmin
        foreach($permissions as $permission){ //Create & Assign Permissions
            $permission = Permission::findOrCreate($permission,'web');
            $RoleSuperAdmin->givePermissionTo($permission);
            $permission->assignRole($RoleSuperAdmin);
        }

		return redirect('core/sidemenu/create?pos=sidebar')->with('success', 'Bulk menu has been deployed successfully!')->with('status','success');
	}



	function store(Request $request){

		$rules = array(
			'menu_name'	=> 'required',	
			'active'	=> 'required',	
			'menu_type'	=> 'required',
			'position'	=> 'required',	
		);

		$validator = Validator::make($request->all(), $rules);	

		if ($validator->passes()) {
			if (isset($request->menu_id) && !empty($request->menu_id)) {
				$menu = Sidemenu::find($request->menu_id);
			}else{
				$menu = new Sidemenu();
			}

			$menu->module = $request->input('module');	
			$menu->url = $request->input('url');	
			$menu->menu_name = $request->input('menu_name');	
			$menu->menu_type = $request->input('menu_type');	
			$menu->position = $request->input('position');	
			$menu->menu_icons = $request->input('menu_icons');	
			$menu->active = $request->input('active');	

			$arr = array();
			$groups = \DB::table('roles')->get();
			foreach($groups as $g)
			{
				$arr[$g->name] = (isset($_POST['groups'][$g->name]) ? "1" : "0" );	
			}

			$menu->access_data = json_encode($arr);		
			$menu->allow_guest = $request->input('allow_guest');
			
			$menu->save();
			
			return redirect()->back()
				->with('success', 'Menu item has been saved successfully!')->with('status','success');
		} else {
			return redirect()->back()
				->with('error', 'The following errors occurred')->with('status','error')->withErrors($validator)->withInput();
		}	
	}

	function postSaveorder( Request $request, $id =0){

		$rules = array(
			'reorder'	=> 'required'
		);

		$validator = Validator::make($request->all(), $rules);	

		if ($validator->passes()) {
			$menus = json_decode($request->input('reorder'),true);

			$child = array();
			$a=0;
			foreach($menus as $m)
			{			
				if(isset($m['children']))
				{
					$b=0;
					foreach($m['children'] as $l)					
					{
						if(isset($l['children']))
						{
							$c=0;
							foreach($l['children'] as $l2)
							{
								$level3[] = $l2['id'];
								\DB::table('core_menu')->where('menu_id','=',$l2['id'])
									->update(array('parent_id'=> $l['id'],'ordering'=>$c));
								$c++;	
							}		
						}
						\DB::table('core_menu')->where('menu_id','=', $l['id'])
							->update(array('parent_id'=> $m['id'],'ordering'=>$b));	
						$b++;
					}							
				}
				\DB::table('core_menu')->where('menu_id','=', $m['id'])
					->update(array('parent_id'=>'0','ordering'=>$a));
				$a++;		
			}

			return redirect()->back()->with('success', 'Data Has Been Save Successfull')->with('status','success');
		} else {
			return redirect()->back()->with('error', 'The following errors occurred')->with('status','error');
		}	
	}
	

	public function destroy(Request $request,$id){

		if(is_null($this->user)){
            return redirect()->route('dashboard')->with('error', self::MESSAGE);
        }

		$result = DB::table('core_menu')->where('menu_id',$id)->delete();
		if($result){
			return redirect('core/sidemenu/create/?pos='.$request->input('pos'))
				->with('success', 'Successfully deleted row!')->with('status','success');
		}else{
			return redirect('core/sidemenu/create/?pos='.$request->input('pos'))
				->with('error', 'Unable to delete this record!')->with('status','error');
		}

		

	}

	public function getIcons(Request $request ,$id = null  )
	{
		return view('core.sidemenu.icons');
	}
	
	
}
