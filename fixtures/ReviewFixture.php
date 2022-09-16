<?php

namespace app\fixtures;

use TaskForce\test\ActiveFixture;
use app\models\Review;
use app\models\Task;
use app\models\User;
use TaskForce\constants\TaskStatus;
use TaskForce\constants\UserRole;
use yii\db\ActiveQuery;

class ReviewFixture extends ActiveFixture
{
    public $tableName = 'reviews';
    public $depends = [TaskFixture::class, UserFixture::class];

    public function afterLoad()
    {
        $contractors =
            User::find()->where(['role' => UserRole::CONTRACTOR])->all();

        foreach ($contractors as $contractor) {
            $contractorId = $contractor->id;

            $reviewTaskSubQuery =
                function (ActiveQuery $query) use ($contractorId) {
                    return $query->andWhere(['contractor_id' => $contractorId]);
                };

            $reviewsQuery =
                Review::find()
                      ->joinWith(['task' => $reviewTaskSubQuery]);

            $ratesSum = $reviewsQuery->sum('rate');

            $reviewsCount = $reviewsQuery->count();

            $failedTasksCount = Task::find()->where(
                [
                    'status' => TaskStatus::FAILED,
                    'contractor_id' => $contractorId
                ]
            )->count();

            $rating = $ratesSum / ($reviewsCount + $failedTasksCount);
            $contractor->rating = $rating;
            $contractor->save();
        }
    }
}
