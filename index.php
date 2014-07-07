<?php

error_reporting(-1);
ini_set('display_errors', 'On');

// TODO: Move to functions file
$urlBase = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].strtok($_SERVER['REQUEST_URI'], '?' );

// Get the base url of the application
define( 'URL_BASE', $urlBase );

// Sets the route of the project
define( 'ABS_PATH', __DIR__ );

function pjn_autoload($class) {

    // Directories to search
    $directories = array(
        'controllers',
        'models',
        'views',
        'lib'
    );

    // Loop directories
    foreach( $directories as $dir ) {

        // Build file path for current directory
        $file = __DIR__ . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . lcfirst( $class ) . '.php';

        // Include the file once if it exists and escape
        if( file_exists( $file ) ) {
            include_once( $file );
            return;
        }
    }
}

spl_autoload_register('pjn_autoload');

$conn = new Database();
session_start();

$GLOBALS['db'] = $conn->db;

$router = new Router();
$router->route();
