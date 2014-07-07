<?php

class AdminController extends baseController{

    // TODO: Move error messages on redirects to session from the URL

    public function login() {

        // Set base URL
        $loginUrl = URL_BASE . '?controller=admin&action=login';

        // No post data, just render the view
        if( empty( $_POST ) ) {
            return $this->loadView('login', array( 'loginUrl' => $loginUrl ) );
        }

        // Either username or password is missing
        if( empty( $_POST['username'] ) || empty( $_POST['password'] ) ) {

            // TODO: Write more specific error messages

            return $this->loadView('login', array( 'error' => 'Missing fields, please check your details and try again', 'loginUrl' => $loginUrl ) );
        }

        $user = new UserModel();
        $result = $user->login( $_POST['username'], $_POST['password'] );

        // User not found
        if( $result == false ) {

            return $this->loadView('login', array( 'error' => 'No user was found with that username and password combination', 'loginUrl' => $loginUrl ) );

        // User found
        } else {

            // User is not verified
            if( $result['verified'] != 1 ) {
                // TODO: Add option to resend verification email

                return $this->loadView('login', array( 'error' => 'You have yet to verify your account, please check your email', 'loginUrl' => $loginUrl ) );
            }

            // Save the user to the session
            $_SESSION['currentUser'] = $result;

            // Redirect to the dashboard
            $this->redirect( 'admin', 'dashboard' );
        }
    }

    public function register() {

        // No post data, render the form
        if( empty( $_POST ) ) {
            $this->loadView('register');
            return;
        }

        // Create the new user
        $user = new UserModel();
        $result = $user->create($_POST);
        $userId = $user->getInsertId();

        var_dump( $result );

        // Error, tell user
        if( $result !== true ) {
            $this->loadView('register', array( 'error' => $result ) );

        // Complete the registration
        } else {

            // TODO: Make an email class - put it in the lib directory
            $to = $_POST['email'];
            $subject = 'Your FP Login registration';
            $content = '<a href="' . URL_BASE . '?controller=admin&action=verify&id=' . $userId .'" title="Verify your account" >Verify your account</a>';
            $headers = 'From: registration@fp-login.com' . "\r\n";

            // Send email
            mail( $to, $subject, $content, $headers );
            // TODO: Display error if email failed to send

            // Redirect to the verify page
            $this->redirect( 'admin', 'thankyou', array( 'email' => $_POST['email'] ) );
        }
    }

    public function thankyou() {
        $this->loadView('thankyou');
    }

    public function verify() {

        // Check if an ID is set
        if( isset( $_GET['id'] ) ) {

            // Update the user
            $user = new UserModel();
            $result = $user->update( $_GET['id'], array( 'verified' => 1 ) );

            // Verified successfully
            if( $result == true ) {

                // Get the user
                $userData = $user->get( $_GET['id'] );

                // Load the view with the user data
                return $this->loadView('verify', array( 'userData' => $userData, 'Message' ) );
            }

            // TODO: Show error message
        }

        // No ID specified, 404
        $this->_404();
    }

    public function dashboard() {

        // User is logged in
        if( isset( $_SESSION['currentUser'] ) ) {

            // Build logout url
            $logoutUrl = URL_BASE . '?controller=admin&action=logout';

            // Load the dashboard
            return $this->loadView('dashboard', array( 'username' => $_SESSION['currentUser']['username'], 'logoutUrl' => $logoutUrl ) );

        // User is not logged in, redirect to login
        } else {
            return $this->redirect('admin', 'login', array( 'error' => 'You must login to view that page' ) );
        }
    }

    public function logout() {

        // Remove the current user
        unset( $_SESSION['currentUser'] );

        // Return to login page
        return $this->redirect('admin', 'login', array( 'error' => 'You have been logged out' ) );
    }
}