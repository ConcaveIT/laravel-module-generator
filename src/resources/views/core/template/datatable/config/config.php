<?php
        $template = base_path().'/resources/views/core/template/datatable/';
        $controller = file_get_contents(  $template.'controller.tpl' );
        $controller_api = file_get_contents(  $template.'controller_api.tpl' );
        $grid = file_get_contents(  $template.'grid.tpl' );               
        $view = file_get_contents(  $template.'view.tpl' );
        $form = file_get_contents(  $template.'form.tpl' );
        $model = file_get_contents(  $template.'model.tpl' );
       
        $build_controller       = \Helper::blend($controller,$codes);   
        $build_controller_api   = \Helper::blend($controller_api,$codes);    
        $build_view             = \Helper::blend($view,$codes);    
        $build_form             = \Helper::blend($form,$codes);    
        $build_grid             = \Helper::blend($grid,$codes);    
        $build_model            = \Helper::blend($model,$codes);    
           
        file_put_contents(  $dirC ."{$ctr}Controller.php" , $build_controller) ;    
        file_put_contents(  $dirApi ."{$ctr}Controller.php" , $build_controller_api) ;    
        file_put_contents(  $dirM ."{$ctr}.php" , $build_model) ;

        file_put_contents(  $dir."/index.blade.php" , $build_grid) ; 
        file_put_contents( $dir."/form.blade.php" , $build_form) ;
        file_put_contents(  $dir."/view.blade.php" , $build_view) ;       
                                  
        
        

?>             