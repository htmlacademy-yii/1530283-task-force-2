<?php

namespace app\controllers;

use app\models\Task;
use TaskForce\constants\TaskStatus;
use yii\db\ActiveQuery;
use yii\web\Controller;
use app\models\User;
use TaskForce\constants\UserRole;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
    /**
     * Показывает ....
     *
     * @return string
     */
    public function actionView(int $id)
    {
        $userReviewedTasksQuery = function (ActiveQuery $query) {
            return $query->where(['status' => TaskStatus::COMPLETED])
                         ->joinWith('review', true, 'RIGHT JOIN')
                         ->with('customer', 'city');
        };

        $user = User::find()
                    ->where(['id' => $id, 'role' => UserRole::CONTRACTOR])
                    ->with(['tasks' => $userReviewedTasksQuery])
                    ->with('categories')
                    ->one();

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $completedTasksCount = Task::find()
                                   ->where(
                                       [
                                           'contractor_id' => $id,
                                           'status' => TaskStatus::COMPLETED
                                       ]
                                   )->count();

        $failedTasksCount = Task::find()
                                ->where(
                                    [
                                        'contractor_id' => $id,
                                        'status' => TaskStatus::FAILED
                                    ]
                                )->count();

        $age = $user->birthdate ? date_diff(
            date_create($user->birthdate),
            date_create('now')
        )->y : null;

//        print '<pre>';
//        var_dump(count($user->tasks));
//        print_r($user->tasks[0]->customer);
//        print_r($user);
//        print '</pre>';

        return $this->render(
            'view',
            [
                'user' => $user,
                'age' => $age,
                'reviewedTasks' => $user->tasks,
                'completedTasksCount' => $completedTasksCount,
                'failedTasksCount' => $failedTasksCount
            ]
        );
    }
}
