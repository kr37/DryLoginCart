<?php

namespace kr37\drylogincart\services;

use Craft;
use craft\db\Query;
use yii\base\Component;
use kr37\drylogincart\DryLoginCart as Plugin;

/**
 * Customer Service service
 */
class CustomerService extends Component
{
    
    function verifyLoginCredentials($email, $password) {
        // If valid, returns customer ID, otherwise null.
        $customer = (new Query())
            ->select(['*'])
            ->from([Plugin::CUSTOMERS_TABLE])
            ->where(['primary_email' => $email])
            ->one();
        //var_dump($customer); die;
        if ($customer == NULL || !password_verify($password, $customer['password'])) {
            return null;
        }
        return $customer;
    }

    static function isLoggedIn() {
        return isset($_SESSION['loggedin']);
    }

}
