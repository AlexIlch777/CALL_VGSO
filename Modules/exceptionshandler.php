<?php

namespace Modules;
class ExceptionsHandler
{
    public static function exceptionHandler($e)
    {
        $controller = new \Modules\Controller\ErrorController;

        if($e instanceof \Modules\Exception\Page404Exception) {
            $controller->page404();
        } else if ($e instanceof \Modules\Exception\Page403Exception) {
            $controller->page403();
        } else {
            $controller->page503($e);
        }
    }
}

set_exception_handler(['\Modules\ExceptionsHandler', 'exceptionHandler']);

?>