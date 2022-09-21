<?php

use yii\web\View;
use app\models\RegistrationForm;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var RegistrationForm $registrationFormModel
 * @var array $cities
 */

$this->title = 'Регистрация';
?>

<main class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php
            $form = ActiveForm::begin(
                ['method' => 'post', 'action' => ['']]
            ); ?>
            <h3 class="head-main head-task">Регистрация нового
                пользователя</h3>
            <?= $form
                ->field($registrationFormModel, 'name');
            ?>

            <div class="half-wrapper">
                <?= $form
                    ->field($registrationFormModel, 'email');
                ?>

                <?= $form
                    ->field($registrationFormModel, 'cityId',)
                    ->dropDownList($cities);
                ?>
            </div>

            <div class="half-wrapper">
                <?= $form->field(
                    $registrationFormModel,
                    'password',
                    ['inputOptions' => ['type' => 'password']]
                );
                ?>

            </div>

            <div class="half-wrapper">
                <?= $form->field(
                    $registrationFormModel,
                    'repeatedPassword',
                    ['inputOptions' => ['type' => 'password']]
                );
                ?>
            </div>

            <?= $form
                ->field($registrationFormModel, 'isContractor')
                ->checkbox(
                    [
                        'labelOptions' => [
                            'class' => 'control-label checkbox-label'
                        ]
                    ]
                ); ?>

            <input type="submit" class="button button--blue"
                   value="Создать аккаунт">
            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</main>
