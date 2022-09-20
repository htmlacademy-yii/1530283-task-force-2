<?php

namespace TaskForce\helpers;

use Yii;

class MainLayoutHelper
{
    const REGISTRATION_URL = '/registration';

    static public function isGuest(): bool
    {
        return str_contains(
            Yii::$app->request->getUrl(),
            self::REGISTRATION_URL
        );
    }
}
