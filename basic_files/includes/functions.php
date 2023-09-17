<?php 

    function classAutoLoader($class){
        $class = strtolower($class);
        $the_path = INCLUDES_PATH . "/{$class}.php";

        if(file_exists($the_path)){
            require_once($the_path);
        } else {
            die("This file name{$class}.php was not found");
        }
    }
    
    spl_autoload_register('classAutoLoader');

    function redirect($location){
        header("Location:{$location}");
    }




?>