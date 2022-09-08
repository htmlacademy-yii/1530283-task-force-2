<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */


use app\models\User;
use app\models\Category;

$users = User::find()->all();
$categories = Category::find()->all();
$userIds = array_column($users, 'id');
$categoryIds = array_column($categories, 'id');

$getCombinations = function (array $array1, array $array2): array {
    $combinations = [];

    for ($i = 0; $i < count($array1); $i++) {
        for ($j = 0; $j < count($array2); $j++) {
            $value1 = $array1[$i];
            $value2 = $array2[$j];
            $combinations[] = [$value1, $value2];
        }
    }

    return $combinations;
};

$userCategoryCombinations = $getCombinations($userIds, $categoryIds);

list(
    $userId,
    $categoryId
    ) = $faker->unique()->randomElement($userCategoryCombinations);

return [
    'user_id' => $userId,
    'category_id' => $categoryId,
];
