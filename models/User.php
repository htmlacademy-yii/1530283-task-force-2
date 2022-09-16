<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property int $city_id
 * @property string $role
 * @property string $created_at
 * @property int|null $is_contacts_hidden
 * @property string|null $birthdate
 * @property string|null $phone_number
 * @property string|null $telegram
 * @property string|null $description
 * @property string|null $avatar_url
 * @property float $rating
 *
 * @property Category[] $categories
 * @property City $city
 * @property Response[] $responses
 * @property Task[] $tasks
 */
class User extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password_hash', 'city_id'], 'required'],
            [['city_id', 'is_contacts_hidden'], 'integer'],
            [['role'], 'string'],
            [['created_at', 'birthdate', 'rating'], 'safe'],
            [['name', 'email', 'avatar_url'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 60],
            [['phone_number'], 'string', 'max' => 11],
            [['telegram'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 1000],
            [['email'], 'unique'],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']
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
            'name' => 'Name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'city_id' => 'City ID',
            'role' => 'Role',
            'created_at' => 'Created At',
            'is_contacts_hidden' => 'Is Contacts Hidden',
            'birthdate' => 'Birthdate',
            'phone_number' => 'Phone Number',
            'telegram' => 'Telegram',
            'description' => 'Description',
            'avatar_url' => 'Avatar Url',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
                    ->viaTable('users_categories', ['user_id' => 'id'])
                    ->inverseOf('users');
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['contractor_id' => 'id'])
                    ->inverseOf('contractor');
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        $role = $this->role;

        return $this->hasMany(Task::class, ["{$role}_id" => 'id'])
                    ->inverseOf($role);
    }
}
