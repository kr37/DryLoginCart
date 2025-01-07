<?php

namespace kr37\drylogincart\controllers;

use Craft;
use craft\web\Controller;
use yii\web\Response;

/**
 * Login controller
 */
class LoginController extends Controller
{
    public $defaultAction = 'index';
    protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_NEVER;

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

        session_start();

        // Establish the db connection.
        include_once "dbConnect.php";
        $con = dbConnect();


        // Now we check if the data from the login form was submitted, isset() will check if the data exists.
        if ( !isset($_POST['primary_email'], $_POST['password']) ) {
            // Could not get the data that should have been sent.
            exit('Please fill both the primary_email and password fields!');
        }


        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $con->prepare('SELECT id, password FROM kmcwa_customers WHERE primary_email = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the primary_email is a string so we use "s"
            $stmt->bind_param('s', $_POST['primary_email']);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $password);
                $stmt->fetch();
                // Account exists, now we verify the password.
                // Note: remember to use password_hash in your registration file to store the hashed passwords.
                if (password_verify($_POST['password'], $password)) {
                    // Verification success! User has logged-in!
                    // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['primary_email'];
                    $_SESSION['id'] = $id;
                    //echo 'Welcome back, ' . htmlspecialchars($_SESSION['name'], ENT_QUOTES) . '!';
                    header('Location: home.php');
                } else {
                    // Incorrect password
                    echo 'Incorrect primary_email and/or password!';
                }
            } else {
                // Incorrect primary_email
                echo 'Incorrect primary_email and/or password!';
            }

            $stmt->close();
        }
    }
}
