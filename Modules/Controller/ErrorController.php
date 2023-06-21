<?php

namespace Modules\Controller;
class ErrorController extends BaseController
{
    public function page404()
    {
        $context = 
        [
            'siteTitle' => 'Ошибка 404',
            'style' => 'page404'
        ];
        $this->render('page404', $context);
    }

    public function page403($e)
    {
        $context = 
        [
            'siteTitle' => 'Ошибка 403',
            'style' => 'page403'
        ];
        $this->render('page403', $context);
    }

    public function page503($e)
    {
        $context = 
        [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
        $this->render('page503', $context);
    }
}

?>