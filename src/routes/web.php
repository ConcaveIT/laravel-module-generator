<?php
namespace Concaveit\Modulegenerator\Routes;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'concave','middleware' => ['web', 'auth']], function(){

	// GET	/photos	index	photos.index
	// GET	/photos/create	create	photos.create
	// POST	/photos	store	photos.store
	// GET	/photos/{photo}	show	photos.show
	// GET	/photos/{photo}/edit	edit	photos.edit
	// PUT/PATCH	/photos/{photo}	update	photos.update
	// DELETE	/photos/{photo}	destroy	photos.destroy


    Route::resource('/module',Concaveit\Media\Controllers\ModuleGeneratorController::class);
    Route::any('/build-module/{id}',[Concaveit\Media\Controllers\ModuleGeneratorController::class,'buildModule'])->name('module.build');

    Route::resource('/sidemenu',Concaveit\Media\Controllers\SideMenuController::class);
    Route::get('/sidemenu/edit/{any?}',[Concaveit\Media\Controllers\SideMenuController::class,'edit']);
    Route::get('/sidemenu-bulk-create',[Concaveit\Media\Controllers\SideMenuController::class,'bulkCreate']);
    Route::get('/sidemenu/destroy/{any?}',[Concaveit\Media\Controllers\SideMenuController::class,'destroy']);

    Route::get('/menu/icon',[Concaveit\Media\Controllers\SideMenuController::class,'getIcons']);
    Route::post('menu/save',[Concaveit\Media\Controllers\SideMenuController::class,'store']);
    Route::post('menu/saveorder',[Concaveit\Media\Controllers\SideMenuController::class,'postSaveorder']);

    Route::get('/database-columns/{databasename}',[Concaveit\Media\Controllers\ModuleGeneratorController::class,'getDatabaseColumns'])->name('database.columns');
    Route::get('/database-relation-options',[Concaveit\Media\Controllers\ModuleGeneratorController::class,'getDatabaseRelationOptions'])->name('database.relation.options');
    
    Route::get('/create-migration',[Concaveit\Media\Controllers\ModuleGeneratorController::class,'createMigration'])->name('module.create.migration');
    Route::post('/generate-migration',[Concaveit\Media\Controllers\ModuleGeneratorController::class,'generateMigration'])->name('module.generate.migration');

    Route::post('/api-login',[Concaveit\Media\Controllers\ModuleGeneratorController::class,'apiLogin'])->name('module.api.login');



});



