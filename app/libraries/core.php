<?php

/** 
 * @author EdgarEldy
 */
namespace php_mvc_tutorial\app\libraries\core;

class core
{

    /**
     */
    protected $controller='home';
    protected $method='index';
    protected $params=[];
    
    public function __construct()
    {
        $url=$this->getUrl();

        if (file_exists(CONTROLLERS . $url[0] . '.php')) {
            $this->controller=$url[0];
            unset($url[0]);
        }

        
        require_once CONTROLLERS . $this->controller . '.php';

        $this->controller=new $this->controller;

        
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
              $this->method=$url[1]  ;
              unset($url[1]);
            }
        }
        
        $this->params = $url ? array_values($url) : [] ;
        
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    public function getUrl()
    {
        if (isset($_GET['url'])) {
         $url=rtrim($_GET['url'], '/')   ;
         $url=filter_var($url,FILTER_SANITIZE_URL);
         $url=explode('/',$url);
         return $url;
        }
    }
}

