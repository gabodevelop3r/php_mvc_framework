<?php


spl_autoload_register( function ( $class ){

    $filePath = '../'.str_replace('\\', '/', $class).'.php';

    if( !file_exists( $filePath ) )
        die('No se pudo cargar la clase');

    require_once $filePath;

});