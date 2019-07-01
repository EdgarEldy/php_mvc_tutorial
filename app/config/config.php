<?php
define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', 'http://localhost/php-mvc-tutoriel');
define('CONTROLLERS', APP_ROOT . DS . 'controllers' . DS);
define('LIB', APP_ROOT . DS . 'libraries' . DS);
define('MODELS', APP_ROOT . DS . 'models' . DS);
define('VIEWS', APP_ROOT . DS . 'views' . DS);
define('INC', APP_ROOT . DS . 'views' . DS .'inc' . DS);
define('DEFAULT_LAYOUT', APP_ROOT . DS . 'views' . DS .'templates' . DS);