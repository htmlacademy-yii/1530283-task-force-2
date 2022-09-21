<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\City;
use app\models\RegistrationForm;

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

        if (Yii::$app->request->getIsPost()) {
            $registrationFormModel->load(Yii::$app->request->post());
            if ($registrationFormModel->validate()) {
                echo 'Форма валидна';
                //        var_dump(Yii::$app->security->passwordHashStrategy);
//                Yii::$app->security->generatePasswordHash($user->password);
            }
        }

        $cities = City::find()
                      ->select('name')
                      ->indexBy('id')
                      ->column();


        if (!$registrationFormModel->cityId) {
            $defaultCityId = (int)City::find()
                                      ->select('id')
                                      ->one()->id;
            $registrationFormModel->cityId = $defaultCityId;
            $registrationFormModel->validate('cityId');
        }

        return $this->render(
            'index',
            [
                'cities' => $cities,
                'registrationFormModel' => $registrationFormModel
            ]
        );
    }
}
