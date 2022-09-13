<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Task;
use app\models\Category;
use app\models\Response;
use app\models\TaskFilterForm;
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
        $taskFilterFormModel = new TaskFilterForm();

        if (Yii::$app->request->getIsGet()) {
            $taskFilterFormModel->load(Yii::$app->request->get());
        }

        $tasksQuery = Task::find()
                          ->with('category', 'city')
                          ->where(['status' => TaskStatus::NEW])
                          ->andWhere(
                              ['category_id' => $taskFilterFormModel->categories]
                          )
                          ->andWhere(
                              "`created_at` >= CURRENT_TIMESTAMP() - INTERVAL :period HOUR",
                              [':period' => $taskFilterFormModel->hoursPeriod]
                          );

        if ($taskFilterFormModel->isRemoteOnly) {
            $tasksQuery->andWhere(['city_id' => null]);
        } else {
            // todo: Показываются только задания без привязки к адресу, а также задания из города текущего пользователя.
        }

        if ($taskFilterFormModel->withoutResponsesOnly) {
            $responses = Response::find()->all();
            $respondedTaskIds =
                array_unique(array_column($responses, 'task_id'));
            $tasksQuery->andWhere(['not', ['id' => $respondedTaskIds]]);
        }

        $categories = Category::find()
                              ->select('name')
                              ->indexBy('id')
                              ->column();

        $tasks = $tasksQuery
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

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
