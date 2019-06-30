<?php
require_once 'config/config.php';

spl_autoload_register(function($class){
    $parts = explode('\\', $class);
    require_once LIB . end($parts) . '.php';
});