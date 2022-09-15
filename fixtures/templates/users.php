<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\City;
use TaskForce\constants\UserRole;

$cities = City::find()->select('id')->all();
$cityIds = array_column($cities, 'id');

return [
    'name' => $faker->name,
    'email' => $faker->email,
    'password_hash' => Yii::$app
        ->getSecurity()
        ->generatePasswordHash('password_' . $index),
    'city_id' => $faker->randomElement($cityIds),
    'role' => $faker->randomElement([UserRole::CONTRACTOR, UserRole::CUSTOMER]),
    'created_at' => $faker
        ->dateTimeBetween('-1 month', '-1 week')
        ->format('c'),
    'is_contacts_hidden' => $faker->boolean,
    'birthdate' => $faker->boolean ? $faker
        ->dateTimeBetween('-50 years', '-20 years')
        ->format('c') : null,
    'phone_number' => $faker->boolean ? substr($faker->e164PhoneNumber, 1, 11)
        : null,
    'telegram' => $faker->boolean ? $faker->word : null,
    'description' => $faker->boolean ? $faker
        ->paragraph(3, true) : null,
    'avatar_url' => $faker->boolean ? $faker
        ->imageUrl(150, 150) : null,
    'rating' => 0,
];
