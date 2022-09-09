<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for task filter form.
 *
 * @property string|array $categories
 * @property string|array $additionals
 * @property int $hoursPeriod
 */
class TaskFilterForm extends Model
{
    const REMOTE_ADDITIONAL = 'REMOTE_ONLY';
    const RESPONSE_FREE_ADDITIONAL = 'WITHOUT_RESPONSES_ONLY';

    public string|array $categories = '';
    public string|array $additionals = '';
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
            'additionals' => 'Дполнительно',
            'hoursPeriod' => 'Период',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['categories', 'additionals', 'hoursPeriod'], 'safe']
        ];
    }
}
