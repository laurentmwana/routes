<?php



namespace App\Routes;

class Route {

    private $path;

    private $callback;
    
    private $matches = [];

    /**
     *
     * Route Constructor 
     * 
     * @param string $path
     * @param mixed $callback
     */
    public function __construct(string $path, $callback)
    {
        $this->path = trim($path, '/');
        $this->callback = $callback;
    }

    /**
     * Get the value of path
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the value of callback
     */ 
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     *
     * @param string $url
     * @return boolean
     */
    public function checkUrl (string $url): bool
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->getPath());
        $regex = "#^{$path}$#";

        if(!preg_match($regex, $url, $matches)){
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }


    public function render ()
    {
        return call_user_func_array($this->getCallback(), $this->matches);
    }
}