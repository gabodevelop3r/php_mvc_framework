<?php

namespace App\Controllers;

class Controller{

    public function view( string $filePath ){

        $filePath = str_replace('.', '/', $filePath);


        $baseDir = ( string ) '../resources/views/';
        $extention = ( string ) '.php';
        $dir = ( string ) $baseDir.$filePath.$extention;

        if( file_exists( $dir ) ){

            ob_start();
            include $dir;
            $content = ob_get_clean();
            return $content;

        }else{
            return "El archivo no existe";
        }
    }

}