<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\User;
use TaskForce\constants\UserRole;
use TaskForce\constants\TaskStatus;
use app\models\Category;
use app\models\City;

$city = null;
$contractorId = null;
$customers = User::find()->where(['role' => UserRole::CUSTOMER])->all();
$categories = Category::find()->all();

$customerIds = array_column($customers, 'id');
$categoryIds = array_column($categories, 'id');

if ($faker->boolean) {
    $contractors = User::find()->where(['role' => UserRole::CONTRACTOR])->all();
    $contractorIds = array_column($contractors, 'id');
    $contractorId = $faker->randomElement($contractorIds);
}

if ($faker->boolean) {
    $cities = City::find()->all();
    $cityIds = array_column($cities, 'id');
    $city = City::findOne($faker->randomElement($cityIds));
}

$availableStatuses = $contractorId
    ? [
        TaskStatus::IN_PROGRESS,
        TaskStatus::FAILED,
        TaskStatus::COMPLETED
    ]
    : [
        TaskStatus::NEW,
        TaskStatus::CANCELLED,
    ];
$createdDate = $faker->dateTimeBetween('-2 weeks')->format('c');

return [
    'customer_id' => $faker->randomElement($customerIds),
    'category_id' => $faker->randomElement($categoryIds),
    'status' => $faker->randomElement($availableStatuses),
    'title' => substr_replace($faker->sentence(3), "", -1),
    'description' => $faker->paragraph(3, true),
    'created_at' => $createdDate,
    'contractor_id' => $contractorId,
    'city_id' => $city ? $city->id : null,
    'latitude' => $city ? $city->latitude : null,
    'longitude' => $city ? $city->longitude : null,
    'budget' => $faker->boolean ? $faker->numberBetween(5, 50) * 100 : null,
    'term' => $faker->boolean ? $faker
        ->dateTimeBetween($createdDate, '+1 week')->format('c')
        : null,
];
