<?php
require_once 'config/config.php';

// Cette fonction permet de charger automatiquement les classes core et controller se trouvant dans le dossier libraries
spl_autoload_register(function($class){
    $parts = explode('\\', $class);
    require_once LIB . end($parts) . '.php';
});