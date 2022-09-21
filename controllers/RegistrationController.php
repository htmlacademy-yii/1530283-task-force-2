<?php

namespace app\controllers;

use app\models\User;
use TaskForce\constants\UserRole;
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
                $user = new User();
                $user->name = $registrationFormModel->name;
                $user->email = $registrationFormModel->email;
                $user->city_id = $registrationFormModel->cityId;
                $user->password_hash = Yii::$app
                    ->security
                    ->generatePasswordHash($registrationFormModel->password);
                $user->role = $registrationFormModel->isContractor ?
                    UserRole::CONTRACTOR : UserRole::CUSTOMER;

                $user->save();

                $this->redirect('/tasks/index');
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
