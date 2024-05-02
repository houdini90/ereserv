<?php
/*** configuration *****/
ini_set('display_errors','on');
error_reporting(E_ALL);

class MyAutoload {
    
    public static function start() {

        spl_autoload_register(array(__CLASS__, 'autoload'));

        $root = $_SERVER['DOCUMENT_ROOT'];
        $host = $_SERVER['HTTP_HOST'];

        define('HOST', 'http://'.$host.'/ereserv/');
        define('ROOT', $root.'/ereserv/');
        // define('HOST', 'http://'.$host);
        // define('ROOT', $root);

        define('CONTROLLERS', ROOT.'app/controllers/');
        define('VIEWS', ROOT.'app/views/');
        define('MODELS', ROOT.'app/models/');
        define('CORE', ROOT.'core/');
        // define('ROUTES', ROOT.'app/');
        define('STORAGE', ROOT.'storage/');

        define('ASSETS', HOST.'//assets/');
        define('STORAGES', HOST.'//storage/');
        define('SCRIPTS', HOST.'//assets/scripts/');

    }

    public static function autoload($class) {

        if(file_exists(MODELS.$class.'.php')) {
            include_once(MODELS.$class.'.php');
        }
        else if(file_exists(CONTROLLERS.$class.'.php')) {
            include_once(CONTROLLERS.$class.'.php');
        }
        else if(file_exists(CORE.$class.'.php')) {
            include_once(CORE.$class.'.php');
        }
        // else if(file_exists(ROUTES.$class.'.php')) {
        //     include_once(ROUTES.$class.'.php');
        // }

        // require_once 'vendor/autoload.php';
        include_once('./app/routes.php');
    }

    public static function sql_details() {
        return array ( 'user' => 'root', 'pass' => '', 'db'   => 'ereserv', 'host' => 'localhost' );
    }

    // public static function dbconnect() {
    //     return new PDO("mysql:host=localhost;dbname=ereserv;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // }
    
}