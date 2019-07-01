<?php

/** 
 * @author Edgard
 * 
 */
class controller
{

    /**
     */
    private $layout='default';
    public function model($model)
    {
        require_once MODELS .$model. '.php';
        
        //On instancie le modele
        return new $model() ;
    }
    
    // La fonction render permet de recuperer la vue avec son template
    
    public function render($view, $data=[])
    {
        ob_start();
        // On verifie que la vue existe
        if(file_exists(VIEWS . $view . '.php')) {
            require_once (VIEWS . $view . '.php');
        } else{
            die ('La vue n\'existe pas ');
        }
        // La variable content contient la vue en memoire tampon
        $content=ob_get_clean();
        require_once DEFAULT_LAYOUT . $this->layout . '.php';
    }
}

