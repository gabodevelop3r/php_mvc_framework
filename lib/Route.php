<?php

namespace Lib;

class Route {

    private static $routes = [];

    /***
     * 
     * Metodos GET
     * Obtiene la url y la devuelve sin slash 
     * 
     */
    public static function get( $uri, $callback ){
        $uri = self::trimUri( $uri );
        self::$routes['GET'][$uri] = $callback;
    }
    /***
     * 
     * Metodos POST
     * Obtiene la url y la devuelve sin slash 
     * 
     */
    public static function post( $uri, $callback ){
        $uri = self::trimUri( $uri );
        self::$routes['POST'][$uri] = $callback;
    }

    public static function dispatch( ){
        $uri = self::trimUri( $_SERVER['REQUEST_URI'] );
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach (self::$routes[$method] as $route => $callback) :

            if( $route == $uri ):
                $callback();
                return ;
            endif;

        endforeach;

        echo '404 not found';
    }

    /**
     * Remover slash de las urls
     */
    private static function trimUri( string $uri){
        return trim( $uri , '/' );
    }
}