<?php

/** 
 * @author Edgard
 * 
 */
class home extends controller
{

    /**
     */
    public function __construct()
    {
        
    }
    
    public function index()
    {
        $this->render('home/index');
    }
    
    public function about()
    {
        $this->render('home/about');
    }
}

