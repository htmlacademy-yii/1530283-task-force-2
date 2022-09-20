<?php

namespace app\controllers;

use app\models\RegistrationForm;
use yii\web\Controller;

class RegistrationController extends Controller
{
    /**
     * Показывает страницу регистрации нового пользователя.
     *
     * @return string
     */
    public function actionIndex()
    {
        $registrationFormModel = new RegistrationForm();

        // todo: Получить все города

        return $this->render(
            'index',
            ['registrationFormModel' => $registrationFormModel]
        );
    }
}
