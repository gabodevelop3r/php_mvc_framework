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

            if( strpos($route, ':') !== false) : # verifica si dentro de la ruta existe : 
                $route = preg_replace( '#:[a-zA-Z]+#', '([a-zA-Z]+)', $route);
            endif;

            if( preg_match( "#^$route$#", $uri, $matches ) ) :

                $params = array_slice( $matches ,1 );
                $response = $callback(...$params);
                
                if( is_string($response)):
                    echo $response;
                    return ;
                endif;

                if( is_array($response) || is_object($response) ) :
                    header('content-type', 'application/json');
                    echo json_encode($response);
                endif;

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