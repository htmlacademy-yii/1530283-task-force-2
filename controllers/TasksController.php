<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Task;
use app\models\Category;
use app\models\Response;
use app\models\TaskFilterForm;
use yii\db\ActiveQuery;
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
                          ->where(['status' => TaskStatus::NEW]);


        if ($taskFilterFormModel->categories) {
            $tasksQuery->andWhere(
                ['category_id' => $taskFilterFormModel->categories]
            );
        }

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

        if ($taskFilterFormModel->hoursPeriod) {
            $tasksQuery->andWhere(
                "`created_at` >= CURRENT_TIMESTAMP() - INTERVAL :period HOUR",
                [':period' => $taskFilterFormModel->hoursPeriod]
            );
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

    /**
     * Показывает страницы просмотра задачи
     *
     * @return string
     */
    public function actionView(int $id)
    {
        $task = Task::find()
                    ->where(['id' => $id])
                    ->with('category')
                    ->one();

        if (!$task) {
            throw new NotFoundHttpException();
        }

        $contractorTasksSubQuery = function (ActiveQuery $query) {
            return $query->where(['status' => TaskStatus::COMPLETED]);
        };

        $responseContractorQuery = function (
            ActiveQuery $query
        ) use ($contractorTasksSubQuery) {
            return $query->with(['tasks' => $contractorTasksSubQuery]);
        };

        $responses = Response::find()
                             ->where(['task_id' => $task->id])
                             ->with(
                                 ['contractor' => $responseContractorQuery]
                             )
                             ->orderBy('created_at DESC')
                             ->all();

        return $this->render(
            'view',
            [
                'task' => $task,
                'responses' => $responses,
            ]
        );
    }
}
