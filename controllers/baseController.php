<?php

class baseController {

    protected $viewsDirectory = 'views';

    /**
     * 404 response
     */
    public function _404() {

        http_response_code(404);
        die('404: Page not found');
    }

    /**
     * loads the requested view
     *
     * @param $view string name of the template we want to load
     * @param $viewData array data to be made available in the view
     */
    protected function loadView( $view, $viewData = array() ) {

        // Add URL paramaters to the view data
        $viewData = array_merge( $viewData, $_GET );

        // Get the folder to load the view from
        $className = get_class($this);
        $className = strtolower($className);
        $controllerDirectory = str_replace('controller','',$className);

        // Get file path
        $filePath = ABS_PATH . DIRECTORY_SEPARATOR . $this->viewsDirectory . DIRECTORY_SEPARATOR . $controllerDirectory . DIRECTORY_SEPARATOR . $view . '.php';

        // Require file if exists
        if( file_exists( $filePath ) ) {
            require_once( $filePath );
        }
    }

    protected function redirect( $controller, $action, $data = array() ) {

        // Build additional query
        $query = http_build_query($data);

        // Build the redirection URL
        $redirectUrl = URL_BASE . '?controller=' . $controller . '&action=' . $action;

        if( !empty( $query ) ) {
            $redirectUrl .= '&' . $query;
        }

        // Redirect and kill the script
        header("Location: " . $redirectUrl );
        die();
    }
}