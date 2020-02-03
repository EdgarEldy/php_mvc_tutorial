<?php

/** 
 * @author Edgard
 * 
 */

namespace Gestion_shift\app\libraries\controller;

class controller
{

    /**
     */
    private $default_layout='default_layout';
    private $new_layout='new_layout';
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
      require_once DEFAULT_LAYOUT . $this->default_layout . '.phtml';
  }
  
  
  
  public function new_view($view, $data= [])
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
      require_once NEW_LAYOUT . $this->new_layout . '.phtml';
  }
}

