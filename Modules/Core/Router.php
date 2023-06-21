<?php

namespace Modules\Core;

final class Router
{
    private $rules;
    private $requestPath;

    private $controllerName;
    private $actionName;

    public function __construct(array $rules, string $requestPath)
    {
        $this->rules = $rules;
        $this->requestPath = $requestPath;
    }

    /**
     * this method define controllerName and actionName by params from url patterns and request methods
     */
    private function findController() 
    {
        $actionParams = array();
        $formArray = array();
        foreach($this->rules as $url => $params) {
            if(preg_match($url, $this->requestPath, $result) === 1) {

                if(isset($params['params'])) {
                    for ($i = 0; $i < count($params['params']); $i++) {
                        $actionParams[$params['params'][$i]] = $result[$i+1];
                    }
                } 

                $this->controllerName = $params['controller'];
                $this->actionName = $params['action'];

                return $actionParams;
            }
        }
    }

    public function createController() 
    {
        $pregMatchResult = $this->findController();
        $controllerName = $this->getControllerName();
        $actionName = $this->getActionName();
        if($controllerName !== '' && $actionName) {
            $controller = new $controllerName;
            if(empty($pregMatchResult)) {
                $controller->$actionName();
            } else {
                $controller->$actionName($pregMatchResult);
            }
        } else {
            throw new \Modules\Exception\Page404Exception;
        }
    }

    private function getControllerName()
    {
        if($this->controllerName !== '') {
            return '\Modules\Controller\\'.$this->controllerName.'Controller';
        } else {
            return '';
        }
    }

    private function getActionName()
    {
        return $this->actionName;
    }
}

?>