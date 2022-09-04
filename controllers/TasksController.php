<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Task;
use TaskForce\constants\TaskStatus;
use Throwable;

class TasksController extends Controller
{
    /**
     * Показывает страницу со списком новых задач.
     *
     * @return string
     */
    public function actionIndex()
    {
        try {
            $tasks = Task::find()
                         ->where(['status' => TaskStatus::NEW])
                         ->with('category', 'city')
                         ->orderBy(['created_at' => SORT_DESC])
                         ->all();

            return $this->render('index', ['tasks' => $tasks]);
        } catch (Throwable $exception) {
            return $this->render('index', ['tasks' => null]);
        }
    }
}
