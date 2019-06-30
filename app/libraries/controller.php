<?php

/** 
 * @author Edgard
 * 
 */
class controller
{

    /**
     */
    private $home_layout='home_layout';
    private $default_layout='default_layout';
    public function model($model)
    {
        require_once MODELS .$model. '.php';
        
        //On instancie le modele
        return new $model() ;
    }
    
    public function render($view, $data= [])
    {
        ob_start();
        // Check for view file
        if(file_exists(VIEWS . $view . '.phtml')) {
            require_once (VIEWS . $view . '.phtml');
        } else{
            /// View does not exists
            die ('View does not exists');
        }
        $content=ob_get_clean();
        require_once DEFAULT_LAYOUT . $this->default_layout . '.phtml';
    }
}

