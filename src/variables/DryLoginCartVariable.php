<?php
namespace kr37\drylogincart\variables;

use Craft;

use kr37\drylogincart\DryLoginCart as Plugin;
use kr37\drylogincart\services\CustomerService;
use kr37\drylogincart\services\SettingsService as Settings;
use kr37\drylogincart\models\CustomerModel;

class DryLoginCartVariable
{
    public function getMySetting() {
        return Plugin::$plugin->drylogincart->SettingsService->getMySetting();
    }

    public function getCpCssFile() {
        return Settings::getCpCssFile();
    }

    public function getLoginStatus() {
        return CustomerService::isLoggedIn();
    }

    public function getCustomer() {
        $customer = new CustomerModel;
        return $customer;
    }

    public function calendarObject($fromDateYmd = null, $toDateYmd = null, $atts = array()) {
        $service = new Service;
        return $service->initCal($fromDateYmd, $toDateYmd, $atts);
    }

    public function twigJsonDecode($json) {
        return json_decode($json, true);
    }

}
