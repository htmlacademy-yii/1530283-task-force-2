<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property int $task_id
 * @property int|null $contractor_id
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $comment
 * @property int|null $price
 *
 * @property User $contractor
 * @property Task $task
 */
class Response extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'contractor_id', 'price'], 'integer'],
            [['status'], 'string'],
            [['created_at'], 'safe'],
            [['comment'], 'string', 'max' => 1000],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']
            ],
            [
                ['contractor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['contractor_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'contractor_id' => 'Contractor ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'comment' => 'Comment',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::class, ['id' => 'contractor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
