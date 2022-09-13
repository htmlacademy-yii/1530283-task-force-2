<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reviews`.
 */
class m220910_093102_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'reviews',
            [
                'id' => $this->primaryKey()->unsigned(),
                'task_id' => $this->integer()->unsigned()->notNull()->unique(),
                'rate' => $this->tinyInteger()->unsigned()->notNull(),
                'created_at' => $this
                    ->timestamp()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
                'comment' => $this->string(1000),
            ]
        );

        $this->addForeignKey(
            'fk-reviews-task_id',
            'reviews',
            'task_id',
            'tasks',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-reviews-task_id', 'reviews');

        $this->dropTable('reviews');
    }
}
