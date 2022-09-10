<?php

use yii\db\Migration;

/**
 * Handles the creation of table `responses`.
 */
class m220910_091952_create_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'responses',
            [
                'id' => $this->primaryKey()->unsigned(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'contractor_id' => $this->integer()->unsigned()->notNull(),
                'status' => "ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending'",
                'created_at' => $this
                    ->timestamp()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
                'comment' => $this->string(1000),
                'price' => $this->integer()->unsigned(),

            ]
        );

        $this->createIndex(
            'idx-responses-task_id-contractor_id',
            'responses',
            ['task_id', 'contractor_id'],
            true
        );

        $this->addForeignKey(
            'fk-responses-task_id',
            'responses',
            'task_id',
            'tasks',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-responses-contractor_id',
            'responses',
            'contractor_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public
    function safeDown()
    {
        $this->dropForeignKey('fk-responses-task_id', 'responses');

        $this->dropForeignKey('fk-responses-contractor_id', 'responses');

        $this->dropIndex('idx-responses-task_id-contractor_id', 'responses');

        $this->dropTable('responses');
    }
}
