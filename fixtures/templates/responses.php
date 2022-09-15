<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\User;
use app\models\Task;
use TaskForce\constants\UserRole;
use TaskForce\constants\TaskStatus;
use TaskForce\constants\ResponseStatus;
use TaskForce\helpers\FixtureHelper;

$contractors = User::find()->where(['role' => UserRole::CONTRACTOR])->all();
$newTasks = Task::find()->where(['status' => TaskStatus::NEW])->all();

$contractorIds = array_column($contractors, 'id');
$newTasksIds = array_column($newTasks, 'id');

$contractorTaskCombinations =
    FixtureHelper::getCombinations($contractorIds, $newTasksIds);

try {
    list(
        $contractorId,
        $taskId
        ) = $faker->unique()->randomElement($contractorTaskCombinations);

    $task = Task::findOne($taskId);

    $availableStatuses = [
        ResponseStatus::PENDING,
        ResponseStatus::ACCEPTED,
        ResponseStatus::REJECTED
    ];

    $createdDate = $faker->dateTimeBetween($task->created_at)->format('c');

    return [
        'task_id' => $taskId,
        'contractor_id' => $contractorId,
        'status' => $faker->randomElement($availableStatuses),
        'created_at' => $createdDate,
        'comment' => $faker->boolean ? $faker->paragraph(3, true) : null,
        'price' => $faker->boolean ? $faker->numberBetween(5, 50) * 100 : null,
    ];
} catch (Throwable $error) {
    return null;
}
