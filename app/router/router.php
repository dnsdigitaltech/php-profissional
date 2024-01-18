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
function params($uri, $matchedUri){
    if(!empty($matchedUri)){
        $matchedToGetParams = array_keys($matchedUri)[0];
        return array_diff(
            explode('/',ltrim($uri,'/')),
            explode('/',ltrim($matchedToGetParams,'/'))
        );
    };
    return [];
}
//get routers
function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();

    // $arr1 = [
    //     'user',1,'name','davi'
    // ];
    
    // $arr2 = [
    //     'user','[0-9]+','name','[a-z]+'
    // ];

    // var_dump(array_diff($arr1,$arr2));

    $matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

    if(empty($matchedUri)){
        $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes);
        
        $params = params($uri, $matchedUri);
            var_dump($params);
    }
}