<?php
function routes()
{
    return require 'routes.php';
}
//Uris
function exactMatchUriInArrayRoutes($uri, $routes)
{
    if(array_key_exists($uri, $routes)){
        return [$uri => $routes[$uri]];
    }
    return [];
}
//Uris dinamicas
function regularExpressionMatchArrayRoutes($uri, $routes){
    return array_filter(
        //array_keys($routes),
        $routes,
        function($value)use($uri){
            $regex = str_replace('/', '\/', ltrim($value, '/'));
            return preg_match("/^$regex$/", ltrim($uri, '/'));
        },
        ARRAY_FILTER_USE_KEY
    );
}
function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();
    $matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

    if(empty($matchedUri)){
        $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes);
    }
    var_dump($matchedUri);
}