<?php

namespace kr37\drylogincart\models;

use Craft;
use craft\base\Model;
use kr37\drylogincart\services\CustomerService;

/**
 * Customer Model model
 */
class CustomerModel extends Model
{
    public $firstName = '';
    public $lastName  = '';
    public $primaryEmail = '';
    public $otherIdentifiers = [];

    public $loggedIn = false;

	function __construct($email = null){
		//parent::__construct($this->id, $this->module);
        if (CustomerService::isLoggedIn()) {
            $this->loggedIn     = true;
            $this->primaryEmail = $_SESSION['theRest']['primary_email'];
            $this->firstName    = $this->primaryEmail;
        }
	}

    

    protected function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            // ...
        ]);
    }
}




