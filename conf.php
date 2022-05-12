<?php

use core\DB\MySQL;

define('__ROOT__', dirname(__FILE__) . '/');
define('__SRC__', __ROOT__ . 'src/');
define('__CLASS_DIR__', __SRC__ . 'class/');
define('__CONTROLLER_DIR__', __SRC__ . 'controller/');

require_once('client-conf.php');

global $CLIENT;

$DB_LOG = [];

//autoloader registers an automatic loading of files, provided the files are not manually loaded ie. require_once
//https://www.php.net/manual/en/function.spl-autoload-register.php
spl_autoload_register(function ($class) {
    if(is_file(__CLASS_DIR__ . "/$class.php")) {
        require_once(__CLASS_DIR__ . "/$class.php");
    } else if(is_file(__CONTROLLER_DIR__ . "/$class.php")) {
        require_once(__CONTROLLER_DIR__ . "/$class.php");
    }
});

$DB = new MySQL($CLIENT["db"]["host"], $CLIENT["db"]["name"], $CLIENT["db"]["user"], $CLIENT["db"]["pass"]);
