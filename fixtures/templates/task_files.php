<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Task;

$tasks = Task::find()->all();
$taskIds = array_column($tasks, 'id');

$task = Task::findOne($taskIds);

$filename = $faker->word() . '.' . $faker->fileExtension();

return [
    'task_id' => $faker->randomElement($taskIds),
    'name' => $filename,
    'url' => $faker->url(),
    'size' => $faker->numberBetween(1, 2147483647),
    'created_at' => $task->created_at
];
