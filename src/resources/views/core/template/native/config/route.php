<?php
$val .= "
// Start Routes for ".$module->module_title." 
Route::resource('{$route}',App\\Http\\Controllers\\".$controller."::class);
// End Routes for ".$module->module_title."
"; 
?>