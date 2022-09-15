<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Task;
use TaskForce\constants\TaskStatus;

$completedTasks =
    Task::find()->where(['status' => TaskStatus::COMPLETED])->all();

$completedTaskIds = array_column($completedTasks, 'id');

try {
    $taskId = $faker->unique()->randomElement($completedTaskIds);

    $task = Task::findOne($taskId);

    $createdDate = $faker->dateTimeBetween($task->created_at)->format('c');

    return [
        'task_id' => $taskId,
        'rate' => $faker->numberBetween(1, 2),
        'created_at' => $createdDate,
        'comment' => $faker->boolean ? $faker->paragraph(3, true) : null,
    ];
} catch (Throwable $error) {
    return null;
}


