<?php


namespace App\Routes;



class Router {

    private $routes = [];


    private $nameRoutes = [];

    /**
     * Router Constructor 
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = trim($url, '/');
    }
    

    
    public function get (string $path, $callback, ?string $name): self
    {
        $route = new Route($path, $callback);
        if (!is_null($name)) {

            if (isset($this->nameRoutes[$name])) {
               throw new RouteException("Il y a une route qui porte ce nom ");
            }

            $this->nameRoutes[$name] = $route;
        }
        
        $this->routes['GET'][] = $route;

        return $this;
    }

    public function post (string $path, callable $callback, ?string $name): self
    {
        $route = new Route($path, $callback);

        if (!is_null($name)) {
            $this->nameRoutes[$name] = $route;

            if (isset($this->nameRoutes[$name])) {
                throw new RouteException("Il y a une route qui porte ce nom ");
            }
             
            $this->nameRoutes[$name] = $route;
        }
        
        $this->routes['POST'][] = $route;

        return $this;
    }

    public function run ()
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouteException("Aucune methode n'est définie");
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->checkUrl($this->url)){
                return $route->render();
            }
        }
        throw new RouteException('La route que vous avez pris n\'existe pas ');
    }
}