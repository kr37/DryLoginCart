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
}
