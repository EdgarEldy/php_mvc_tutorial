<?php
use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *        
 */
class home extends controller
{

    /**
     */     
    public function __construct()
    {}
    
    public function index() {
       return $this->render('home/index') ;
    }
}

