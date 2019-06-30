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
    
    public function render($view)
    {
        ob_start();
        // Check for view file
        if(file_exists(VIEWS . $view . '.php')) {
            require_once (VIEWS . $view . '.php');
        } else{
            /// View does not exists
            die ('View does not exists');
        }
        $content=ob_get_clean();
        require_once DEFAULT_LAYOUT . $this->layout . '.php';
    }
}

