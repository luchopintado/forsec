<?php

ini_set("display_errors", true);
error_reporting(error_reporting() & ~E_NOTICE);

define("DB_HOST", "127.0.0.1");
define("DB_NAME", "forsec");
define("DB_PORT", "3306");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");

/*
define("DB_HOST", "localhost");
define("DB_NAME", "forsec_web");
define("DB_PORT", "3306");
define("DB_USERNAME", "forsec_admin");
define("DB_PASSWORD", "Ingreso.12?");*/

define("LIMIT_RESULT", 40);
define("PAGE_TITLE", "FORSEC");
define("CLASS_PATH", "clases");
//define("PENSION_ID", 7);
//define("PERIODO_ACTUAL", 2);

//Core
require 'core/DB.php';
require 'core/DBOCrud.php';
require 'core/EntityBase.php';
require 'extras/Fecha.php';

function handle_exception($exception){
    echo "Ha ocurrido un problema, por favor int&eacute;ntelo m&aacute;s tarde";
    error_log($exception->getMessage());
}

function __autoload($class_name) {
    try {
        if(file_exists(CLASS_PATH.'/models/'.$class_name . '.php')) {
            require_once(CLASS_PATH.'/models/'.$class_name . '.php');
        }
        if(file_exists(CLASS_PATH.'/entities/'.$class_name . '.php')) {
            require_once(CLASS_PATH.'/entities/' . $class_name . '.php');
        }
    } catch (Exception $exc) {

    }
}

set_exception_handler('handle_exception');

?>
