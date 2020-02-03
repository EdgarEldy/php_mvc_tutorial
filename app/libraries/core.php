<?php

/** 
 * @author Edgard
 * permet d'instancier les controller et de recuperer les liens des views dans le naviguateur
 */
namespace Gestion_shift\app\libraries\core;

class core
{

    /**
     */
    protected $controller='dashboard';
    protected $method='index';
    protected $params=[];
    
    public function __construct()
    {
        $url=$this->getUrl();
        
        // On recherche dans les controllers la premiere valeur
        if (file_exists(CONTROLLERS . $url[0] . '.php')) {
            $this->controller=$url[0];
            unset($url[0]);
        }
        
        // Appel du controlleur
        
        require_once CONTROLLERS . $this->controller . '.php';
        
        // On instancie le controlleur
        $this->controller=new $this->controller;
        
        // On verifie la deuxieme valeur du lien 
        
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
              $this->method=$url[1]  ;
              unset($url[1]);
            }
        }
        
        // On recupere les parametres
        
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

