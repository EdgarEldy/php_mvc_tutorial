<?php

/** 
 * @author Edgard
 * 
 */
class core
{

    /**
     */
    
    protected $controller='home';
    protected $method='index';
    protected $params = [];
    public function __construct()
    {
        $url=$this->getUrl();
        
        // On cherche dans le dossier controllers la premiere valeur. Elle doit etre le nom du controlleur
        if (file_exists(CONTROLLERS . $url[0] . '.php')) {
            $this->controller=$url[0]  ;
            unset($url[0]);
        }
        // On charge le controller
        require_once CONTROLLERS . $this->controller . '.php';
        $this->controller = new $this->controller;
        
        //On cherche la 2eme valeur qui est une methode
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method=$url[1]   ;
                unset($url[1]);
            }
        }
        
        $this->params = $url ? array_values($url) : [];
        
        // On appelle le lien sous forme d'un controller, une methode et des parametres
        call_user_func_array([$this->controller , $this->method], $this->params);
    }
    
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url=rtrim($_GET['url'],'/');
            $url=filter_var($url,FILTER_SANITIZE_URL);
            $url=explode('/', $url);
            return $url;
        }
    }
}

