<?php

$val_api .= "
// Start Routes for ".$module->module_title." 
Route::resource('api/{$route}',App\\Http\\Controllers\\Api\\".$controller."::class, [ 'as' => 'api' ]);
// End Routes for ".$module->module_title." 
"; 
?>                    