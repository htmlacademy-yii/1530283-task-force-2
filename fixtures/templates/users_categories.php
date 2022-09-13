<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\User;
use app\models\Category;
use TaskForce\helpers\FixtureHelper;

$users = User::find()->all();
$categories = Category::find()->all();
$userIds = array_column($users, 'id');
$categoryIds = array_column($categories, 'id');

$userCategoryCombinations =
    FixtureHelper::getCombinations($userIds, $categoryIds);

list(
    $userId,
    $categoryId
    ) = $faker->unique()->randomElement($userCategoryCombinations);

return [
    'user_id' => $userId,
    'category_id' => $categoryId,
];
