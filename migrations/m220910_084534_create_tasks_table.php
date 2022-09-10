<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tasks`.
 */
class m220910_084534_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'tasks',
            [
                'id' => $this->primaryKey()->unsigned(),
                'customer_id' => $this->integer()->unsigned()->notNull(),
                'category_id' => $this->integer()->unsigned()->notNull(),
                'status' => "ENUM('new', 'cancelled', 'in_progress', 'completed', 'failed') DEFAULT 'new'",
                'title' => $this->string(255)->notNull(),
                'description' => $this->string(1000)->notNull(),
                'created_at' => $this
                    ->timestamp()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
                'contractor_id' => $this->integer()->unsigned(),
                'city_id' => $this->integer()->unsigned(),
                'latitude' => $this->decimal(9, 7),
                'longitude' => $this->decimal(10, 7),
                'budget' => $this->integer()->unsigned(),
                'term' => $this->timestamp(),
            ]
        );

        $this->addForeignKey(
            'fk-tasks-customer_id',
            'tasks',
            'customer_id',
            'users',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tasks-category_id',
            'tasks',
            'category_id',
            'categories',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tasks-contractor_id',
            'tasks',
            'contractor_id',
            'users',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tasks-city_id',
            'tasks',
            'city_id',
            'cities',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-tasks-customer_id', 'tasks');

        $this->dropForeignKey('fk-tasks-category_id', 'tasks');

        $this->dropForeignKey('fk-tasks-contractor_id', 'tasks');

        $this->dropForeignKey('fk-tasks-city_id', 'tasks');

        $this->dropTable('tasks');
    }
}
