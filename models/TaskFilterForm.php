<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for task filter form.
 *
 * @property string|array $categories
 * @property $additional
 * @property int $hoursPeriod
 */
class TaskFilterForm extends Model
{
    public string|array $categories = '';
    public $additional;
    public int $hoursPeriod = 1;

    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'additional' => 'Дополнительно',
            'hoursPeriod' => 'Период',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['categories', 'additional', 'hoursPeriod'], 'safe']
        ];
    }
}
