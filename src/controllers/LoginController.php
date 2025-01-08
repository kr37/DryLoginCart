<?php

namespace kr37\drylogincart\controllers;

use Craft;
use craft\web\Controller;
use yii\web\Response;
use kr37\drylogincart\services\CustomerService as Customer;

/**
 * Login controller
 */
class LoginController extends Controller
{
    public $defaultAction = 'index';
    //protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_NEVER;
    protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE;

    /**
     * drylogincart/login action
     */
    public function actionIndex(): Response
    {
        // ...
        return $this->asRaw('Hi!');
        return $this->redirectToPostedUrl(null, "https://aeropress.com");
        return $this->goBack();
        return $this->goHome();
        return $this->asJson(['ping' => 'pong']);
    }

    public function actionAuthenticate(): Response {

        // Start PHP session, if not already started
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Now we check if the data from the login form was submitted, isset() will check if the data exists.
        if ( !isset($_POST['primary_email'], $_POST['password']) ) {
            // Could not get the data that should have been sent.
            exit('Please fill both the primary_email and password fields!');
        } else {
            $email    = $_POST['primary_email'];
            $password = $_POST['password'];
        }

        $service = new Customer;
        $customer = $service->verifyLoginCredentials($email, $password);

        if ($customer !== null) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name']     = $email;
            $_SESSION['id']       = $customer['id'];
            $_SESSION['theRest']  = $customer;
            //echo 'Welcome back, ' . htmlspecialchars($_SESSION['name'], ENT_QUOTES) . '!';
            return $this->goBack();
        } else {
            // Incorrect password
            return $this->asRaw('Incorrect primary_email and/or password!');
        }
    }
}
