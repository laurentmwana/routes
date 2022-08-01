<?php

use App\Modules\BlogModule;
use App\Routes\Router;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$route = new Router($_SERVER['REQUEST_URI']);


$route->get('/', [new BlogModule(), 'index'], 'blog.index');
$route->get('/contact', [new BlogModule(), 'contact'], 'blog.contact');


$route->run();