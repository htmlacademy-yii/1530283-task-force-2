<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_files".
 *
 * @property int $id
 * @property int $task_id
 * @property string $name
 * @property string $url
 * @property string|null $created_at
 *
 * @property Task $task
 */
class TaskFile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'name', 'url'], 'required'],
            [['task_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']
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
            'name' => 'Name',
            'url' => 'Url',
            'created_at' => 'Created At',
        ];
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
