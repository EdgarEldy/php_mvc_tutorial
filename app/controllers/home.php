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
    {
    }

    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        } else
            return $this->render('home/index');
    }
}
