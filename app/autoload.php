<?php 
spl_autoload_register(function($classe){

    $diretorios = [
        'Routes',    
        'Database',
        'Controllers',
        'Database',
        'Helpers',
        'Services',
    ];

    foreach ($diretorios as $diretorio) {

  
       

        $arquivo = (__DIR__ . DIRECTORY_SEPARATOR . $diretorio . DIRECTORY_SEPARATOR . $classe . '.php');

        if(file_exists($arquivo)){
            Require_once ($arquivo);
        }
    }
});