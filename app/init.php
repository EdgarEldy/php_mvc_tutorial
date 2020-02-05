<?php
require_once 'config/config.php';

require_once HELPERS . 'datetime_helper.php';
require_once HELPERS . 'session_helper.php';
require_once HELPERS . 'url_helper.php';

spl_autoload_register(function($class){
    $parts = explode('\\', $class);
    require_once LIB . end($parts) . '.php';
});