<?php

/** 
 * @author EdgarEldy
 * 
 */

namespace php_mvc_tutorial\app\libraries\controller;

class controller
{

    /**
     */
    private $default='default';
    public function model($model)
    {
        require_once MODELS .$model. '.php';
        
        return new $model();
    }
    
  public function view($view, $data =[])
  {
      if (file_exists(VIEWS .$view. '.phtml')) {
        require_once VIEWS .$view. '.phtml';  ;
      }
      else 
          die('view does not exist !');
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
      require_once DEFAULT_LAYOUT . $this->default . '.phtml';
  }

}

