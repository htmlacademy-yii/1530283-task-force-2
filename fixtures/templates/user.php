<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */


use TaskForce\constants\UserRole;
use app\models\City;

$cities = City::find()->select('id')->all();
$cityIds = array_column($cities, 'id');

return [
    'name' => $faker->name,
    'email' => $faker->email,
    'password_hash' => 'johncustomerpasswordhash',
    'city_id' => $faker->randomElement($cityIds),
    'role' => $faker->randomElement([UserRole::CONTRACTOR, UserRole::CUSTOMER]),
];
