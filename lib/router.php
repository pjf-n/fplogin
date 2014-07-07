<?php

class Router {

    /**
     * @var string the controller defined in the URL
     */
    private $controller;

    /**
     * @var string the action defined in the URL
     */
    private $action;

    /**
     * @var string where the views are stored
     */
    private $controllersDirectory = 'controllers';

    /**
     * Populates the method property
     *
     * Gets the request method from the server super global
     *
     * Populates the controller if it is set
     */
    public function __construct() {

        $this->method = $_SERVER['REQUEST_METHOD'];

        // Assign the controller
        if ( isset( $_GET['controller'] ) ) {
            $this->controller = $_GET['controller'];

        // No controller set, trigger 404
        } else {
            $this->controller = 'base';
            $this->action = '_404';
            return;
        }

        // Assign the action
        if ( isset( $_GET['action'] ) ) {
            $this->action = $_GET['action'];

        // No action set, trigger 404
        } else {
            $this->action = '_404';
        }
    }

    /**
     * Runs the appropriate controller method
     *
     * Checks to see if there is a controller defined for the controller specified in the URL. Controllers are located
     * in the controllers directory, and the name of the file should match the URL value. Controller class names should
     * be called the file name with "Controller" added to the end, the first character should also be capitalised.
     *
     * If a controller is found, the appropriate method will be called, matching the HTTP request method.
     *
     * Method names are case insensitive, so there is no need to check when checking the appropriate method exists
     * within the controller.
     */
    public function route() {

        // Build the file path
        $filePath = ABS_PATH . DIRECTORY_SEPARATOR . $this->controllersDirectory . DIRECTORY_SEPARATOR . strtolower( $this->controller ) . 'Controller.php';

        // Is there a file to handle this controller
        if( !file_exists( $filePath ) ) {
            return; // Controller not found, escape TODO: Handle appropriately
        }

        // load the controller
        require_once( $filePath );

        // Build the controller name
        $controllerName = ucfirst( $this->controller ) . 'Controller';

        // Create a new instance of the controller
        $controller = new $controllerName();

        // Check the controller has a method for the current request type
        if ( method_exists( $controller, $this->action ) ) {

            // Build the method name
            $actionName = $this->action;

            // Call the method
            $controller->$actionName();
        }
    }
}