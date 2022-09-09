<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for task filter form.
 *
 * @property $categories
 * @property $additional
 * @property $period
 */
class TaskFilterForm extends Model
{
    public string|array $categories = '';
    public $additional;
    public $period;

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
            'period' => 'Период',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['categories', 'additional', 'period'], 'safe']
        ];
    }
}
