<?php

namespace kr37\drylogincart;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

use kr37\drylogincart\models\Settings;
use kr37\drylogincart\services\CartService;
use kr37\drylogincart\services\CustomerService;
use kr37\drylogincart\variables\DryLoginCartVariable;

/**
 * DryLoginCart plugin
 *
 * @method static DryLoginCart getInstance()
 * @method Settings getSettings()
 * @author kr37 <kelsangrinzin@gmail.com>
 * @copyright kr37
 * @license MIT
 * @property-read CustomerService $customerService
 * @property-read CartService $cartService
 */
class DryLoginCart extends Plugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    const CUSTOMERS_TABLE = 'kmcwa_customers';

    public static function config(): array
    {
        return [
            'components' => ['customerService' => CustomerService::class, 'cartService' => CartService::class],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function() {
            // ...
        });

        // Register our variables
        Event::on(
            CraftVariable::class, 
            CraftVariable::EVENT_INIT, 
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('LoginCart', DryLoginCartVariable::class);
             }
        );
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('drylogincart/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
    }
}
