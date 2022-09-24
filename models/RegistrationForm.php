<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for registration form.
 *
 */
class RegistrationForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $repeatedPassword = '';
    public string|int $cityId = '';
    public bool $isContractor = true;

    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
            'repeatedPassword' => 'Повтор пароля',
            'cityId' => 'Город',
            'isContractor' => 'я собираюсь откликаться на заказы'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'email',
                    'password',
                    'repeatedPassword',
                    'cityId'
                ],
                'required'
            ],
            ['email', 'email'],
            [['name', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6, 'max' => 255],
            ['repeatedPassword', 'compare', 'compareAttribute' => 'password'],
            ['email', 'unique', 'targetClass' => User::class],
            [
                'cityId',
                'exist',
                'targetClass' => City::class,
                'targetAttribute' => 'id'
            ],
            ['isContractor', 'safe'],
        ];
    }
}
