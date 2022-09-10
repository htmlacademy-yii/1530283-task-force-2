<?php
/**
 * @var yii\web\View $this
 * @var Task[] $tasks
 * @var array $categories
 * @var TaskFilterForm $filterFormModel
 */

use app\models\Task;
use app\models\TaskFilterForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Новое';
?>
<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>

    <?php
    if (count($tasks)): ?>
        <?php
        foreach ($tasks as $task): ?>
            <p>Responses count: <?= count($task->responses) ?></p>
            <div class="task-card">
                <div class="header-task">
                    <!-- Добавить ссылку на страницу задачи-->
                    <a href="#" class="link link--block link--big">
                        <?= Html::encode($task->title) ?>
                    </a>
                    <?php
                    if (isset($task->budget)): ?>
                        <p class="price price--task">
                            <?= Html::encode($task->budget) ?> ₽
                        </p>
                    <?php
                    endif; ?>
                </div>
                <p class="info-text">
                <span class="current-time">
                    <?= Yii::$app
                        ->formatter
                        ->asRelativeTime($task->created_at)
                    ?>
                </span>
                </p>
                <p class="task-text">
                    <?= Html::encode($task->description) ?>
                </p>
                <div class="footer-task">
                    <p class="info-text town-text">
                        <?= isset($task->city) ? Html::encode($task->city->name)
                            : 'Любой город' ?>
                    </p>
                    <p class="info-text category-text">
                        <?= Html::encode($task->category->name) ?>
                    </p>
                    <!-- Добавить ссылку на страницу задачи-->
                    <a href="#" class="button button--black">Смотреть
                        Задание</a>
                </div>
            </div>
        <?php
        endforeach; ?>

        <div class="pagination-wrapper">
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">1</a>
                </li>
                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">3</a>
                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul>
        </div>
    <?php
    else: ?>
        <p>Задачи отсутствуют</p>
    <?php
    endif; ?>

</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <?php
            $form = ActiveForm::begin(
                ['method' => 'get', 'action' => ['']]
            ); ?>

            <h4 class="head-card">Категории</h4>
            <?= $form
                ->field(
                    $filterFormModel,
                    'categories',
                    [
                        'template' => '{input}',
                        'options' => ['class' => 'form-group'],
                    ]
                )
                ->checkboxList(
                    $categories,
                    [
                        'class' => 'checkbox-wrapper',
                        'itemOptions' => [
                            'labelOptions' => ['class' => 'control-label'],
                        ],
                    ]
                )
                ->label(false);
            ?>

            <h4 class="head-card">Дополнительно</h4>
            <?= $form
                ->field(
                    $filterFormModel,
                    'isRemoteOnly',
                    ['template' => '{input}']
                )
                ->checkbox(['labelOptions' => ['class' => 'control-label']]);
            ?>

            <?= $form
                ->field(
                    $filterFormModel,
                    'withoutResponsesOnly',
                    ['template' => '{input}']
                )
                ->checkbox(['labelOptions' => ['class' => 'control-label']]);
            ?>

            <h4 class="head-card">Период</h4>
            <?= $form
                ->field(
                    $filterFormModel,
                    'hoursPeriod',
                    [
                        'template' => '{input}',
                        'options' => ['class' => 'form-group'],
                    ]
                )
                ->dropDownList(
                    [
                        '1' => '1 час',
                        '12' => '12 часов',
                        '24' => '24 часа',
                    ]
                )
                ->label(false);
            ?>

            <input type="submit" class="button button--blue" value="Искать">
            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>
