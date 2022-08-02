<?php

require_once 'init/common.php';

require_once 'classes/Task.php';
require_once 'classes/TaskStatus.php';

const CUSTOMER_ID = 1;
const CONTRACTOR_ID = 2;
const USER_ID = 3;

$newTask = new Task(CUSTOMER_ID);
$cancelledTask = new Task(CUSTOMER_ID, null, TaskStatus::CANCELLED);
$inProgressTask = new Task(CUSTOMER_ID, CONTRACTOR_ID, TaskStatus::IN_PROGRESS);
$completedTask = new Task(CUSTOMER_ID, CONTRACTOR_ID, TaskStatus::COMPLETED);
$failedTask = new Task(CUSTOMER_ID, CONTRACTOR_ID, TaskStatus::FAILED);

function validateTaskStatusMap(array $map): bool
{
    return is_array($map) && isset($map[TaskStatus::NEW])
           && isset($map[TaskStatus::CANCELLED])
           && isset($map[TaskStatus::COMPLETED])
           && isset($map[TaskStatus::IN_PROGRESS])
           && isset($map[TaskStatus::FAILED]);
}

function validateTaskActionMap(array $map): bool
{
    return is_array($map) && isset($map[TaskAction::CANCEL])
           && isset($map[TaskAction::FAIL])
           && isset($map[TaskAction::COMPLETE])
           && isset($map[TaskAction::RESPOND]);
}

assert(
    validateTaskStatusMap(Task::getStatusMap()),
    'Класс возваращает карту статусов'
);

assert(
    validateTaskActionMap(Task::getActionMap()),
    'Класс возваращает карту действий'
);

assert(
    $newTask->getAction(CUSTOMER_ID) === [TaskAction::CANCEL],
    'Заказчик может отменить новую задачу'
);

assert(
    $newTask->getAction(CONTRACTOR_ID) === [TaskAction::RESPOND],
    'Исполнитель может отклинуться на новую задачу'
);

assert(
    $newTask->getAction(USER_ID) === [TaskAction::RESPOND],
    'Не заказчик может отклинуться на новую задачу'
);

assert(
    $newTask->getNextStatus(TaskAction::CANCEL) === TaskStatus::CANCELLED,
    'Новая задача может быть отменена'
);

assert(
    $newTask->getNextStatus(TaskAction::RESPOND) === TaskStatus::NEW,
    'Новая задача при отклике не меняет статус'
);

assert(
    $newTask->getNextStatus(TaskAction::COMPLETE) === null,
    'Новая задача не может быть завершена'
);

assert(
    $newTask->getNextStatus(TaskAction::FAIL) === null,
    'Новая задача не может быть провалена'
);

assert(
    $cancelledTask->getAction(CUSTOMER_ID) === [],
    'Заказчик ничего не может сделать с отмененной задачей'
);

assert(
    $cancelledTask->getAction(CONTRACTOR_ID) === [],
    'Исполнитель ничего не может сделать с отмененной задачей'
);

assert(
    $cancelledTask->getAction(USER_ID) === [],
    'Не заказчик и не исполнитель ничего не может сделать с отмененной задачей'
);

assert(
    $cancelledTask->getNextStatus(TaskAction::CANCEL) === null,
    'Отмененная задача не может быть отменена повторно'
);

assert(
    $cancelledTask->getNextStatus(TaskAction::RESPOND) === null,
    'На отмененную задачу нельзя сделать отклик'
);

assert(
    $cancelledTask->getNextStatus(TaskAction::COMPLETE) === null,
    'Отмененная задача не может быть завершена'
);

assert(
    $cancelledTask->getNextStatus(TaskAction::FAIL) === null,
    'Отмененная задача не может быть провалена'
);

assert(
    $inProgressTask->getAction(CUSTOMER_ID) === [TaskAction::COMPLETE],
    'Заказчик может завершить задачу, находящуюся в работе'
);

assert(
    $inProgressTask->getAction(CONTRACTOR_ID) === [TaskAction::FAIL],
    'Исполнитель может провалить задачу, находящуюся в работе'
);

assert(
    $inProgressTask->getAction(USER_ID) === [],
    'Не заказчик и не исполнитель ничего не может сделать с задачей, находящейся в работе'
);

assert(
    $inProgressTask->getNextStatus(TaskAction::CANCEL) === null,
    'Задача в работе не может быть отменена'
);

assert(
    $inProgressTask->getNextStatus(TaskAction::RESPOND) === null,
    'На задачу в работе нельзя сделать отклик'
);

assert(
    $inProgressTask->getNextStatus(TaskAction::COMPLETE)
    === TaskStatus::COMPLETED,
    'Задача в работе может быть завершена'
);

assert(
    $inProgressTask->getNextStatus(TaskAction::FAIL) === TaskStatus::FAILED,
    'Задача в работе может быть провалена'
);

assert(
    $completedTask->getAction(CUSTOMER_ID) === [],
    'Заказчик ничего не может сделать с выполненной задачей'
);

assert(
    $completedTask->getAction(CONTRACTOR_ID) === [],
    'Исполнитель ничего не может сделать с выполненной задачей'
);

assert(
    $completedTask->getAction(USER_ID) === [],
    'Не заказчик и не исполнитель ничего не может сделать с выполненной задачей'
);

assert(
    $completedTask->getNextStatus(TaskAction::CANCEL) === null,
    'Завершенная задача не может быть отменена'
);

assert(
    $completedTask->getNextStatus(TaskAction::RESPOND) === null,
    'На завершенную задачу нельзя сделать отклик'
);

assert(
    $completedTask->getNextStatus(TaskAction::COMPLETE) === null,
    'Завершенную задачу нельзя завершить повторно'
);

assert(
    $completedTask->getNextStatus(TaskAction::FAIL) === null,
    'Завершенная задача не может быть провалена'
);

assert(
    $failedTask->getAction(CUSTOMER_ID) === [],
    'Заказчик ничего не может сделать с проваленной задачей'
);

assert(
    $failedTask->getAction(CONTRACTOR_ID) === [],
    'Исполнитель ничего не может сделать с проваленной задачей'
);

assert(
    $completedTask->getAction(USER_ID) === [],
    'Не заказчик и не исполнитель ничего не может сделать с проваленной задачей'
);

assert(
    $failedTask->getNextStatus(TaskAction::CANCEL) === null,
    'Проваленная задача не может быть отменена'
);

assert(
    $failedTask->getNextStatus(TaskAction::RESPOND) === null,
    'На проваленную задачу нельзя сделать отклик'
);

assert(
    $failedTask->getNextStatus(TaskAction::COMPLETE) === null,
    'Проваленная задача не может быть завершена'
);

assert(
    $failedTask->getNextStatus(TaskAction::FAIL) === null,
    'Проваленная задача не может быть провалена повторно'
);

print '<br/>';
print 'Все проверки завершены!';
