<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for task filter form.
 *
 * @property string|array $categories
 * @property bool $isRemoteOnly
 * @property bool $withoutResponsesOnly
 * @property int $hoursPeriod
 */
class TaskFilterForm extends Model
{
    public string|array $categories = '';
    public bool $isRemoteOnly = false;
    public bool $withoutResponsesOnly = false;
    public string|int $hoursPeriod = '';

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
            'isRemoteOnly' => 'Удаленная работа',
            'withoutResponsesOnly' => 'Без откликов',
            'hoursPeriod' => 'Период',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'categories',
                    'isRemoteOnly',
                    'withoutResponsesOnly',
                    'hoursPeriod'
                ],
                'safe'
            ]
        ];
    }
}
