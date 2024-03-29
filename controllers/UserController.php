<?php

namespace app\controllers;

use app\models\Task;
use TaskForce\constants\TaskStatus;
use yii\db\ActiveQuery;
use yii\web\Controller;
use app\models\User;
use TaskForce\constants\UserRole;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * Показывает страницу профиля исполнителя
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



        $betterContractors = User::find()
                                 ->where(['role' => UserRole::CONTRACTOR])
                                 ->andWhere(
                                     'rating > :rating',
                                     [':rating' => $user->rating]
                                 )
                                 ->count();

        $ratingPosition = $betterContractors + 1;

        $isBusy = Task::find()
                      ->where(
                          [
                              'contractor_id' => $id,
                              'status' => TaskStatus::IN_PROGRESS
                          ]
                      )
                      ->exists();

        return $this->render(
            'view',
            [
                'user' => $user,
                'reviewedTasks' => $user->tasks,
                'completedTasksCount' => $completedTasksCount,
                'failedTasksCount' => $failedTasksCount,
                'ratingPosition' => $ratingPosition,
                'isBusy' => $isBusy,
            ]
        );
    }
}
