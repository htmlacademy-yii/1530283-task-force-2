<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Task;
use TaskForce\constants\TaskStatus;

class TasksController extends Controller
{
    /**
     * Показывает страницу со списком новых задач.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tasks = Task::find()
                     ->where(['status' => TaskStatus::NEW])
                     ->with('category')
                     ->orderBy(['created_at' => SORT_DESC])
                     ->all();

        return $this->render('index', ['tasks' => $tasks]);
    }
}
