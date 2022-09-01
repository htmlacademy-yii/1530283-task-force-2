<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $category_id
 * @property string|null $status
 * @property string $title
 * @property string $description
 * @property string|null $created_at
 * @property int|null $contractor_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $budget
 * @property string|null $term
 *
 * @property Category $category
 * @property User $contractor
 * @property User $customer
 * @property Response[] $responses
 * @property Review $review
 * @property TaskFile[] $taskFiles
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['customer_id', 'category_id', 'title', 'description'],
                'required'
            ],
            [
                ['customer_id', 'category_id', 'contractor_id', 'budget'],
                'integer'
            ],
            [['status'], 'string'],
            [['created_at', 'term'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id']
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
            'customer_id' => 'Customer ID',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'contractor_id' => 'Contractor ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'budget' => 'Budget',
            'term' => 'Term',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['task_id' => 'id'])
                    ->inverseOf('task');
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::class, ['task_id' => 'id'])
                    ->inverseOf('task');
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::class, ['task_id' => 'id'])
                    ->inverseOf('task');
    }
}
