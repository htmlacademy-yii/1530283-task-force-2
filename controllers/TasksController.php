<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use yii\web\Controller;
use app\models\Task;
use TaskForce\constants\TaskStatus;
use app\models\TaskFilterForm;

class TasksController extends Controller
{
    /**
     * Показывает страницу со списком новых задач.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()
                              ->select('name')
                              ->indexBy('id')
                              ->column();


        $tasks = Task::find()
                     ->where(['status' => TaskStatus::NEW])
                     ->with('category', 'city')
                     ->orderBy(['created_at' => SORT_DESC])
                     ->all();

        $taskFilterFormModel = new TaskFilterForm();

        if (Yii::$app->request->getIsGet()) {
            $taskFilterFormModel->load(Yii::$app->request->get());
        }

        return $this->render(
            'index',
            [
                'tasks' => $tasks,
                'categories' => $categories,
                'filterFormModel' => $taskFilterFormModel
            ]
        );
    }
}
