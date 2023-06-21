<?php
namespace Modules\Core;
final class Application 
{
    public function run($rules, $requestPath)
    {
        $router = new Router($rules, $requestPath);
        $router->createController();
    }
}

?>