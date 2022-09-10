<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_files`.
 */
class m220910_090458_create_task_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'task_files',
            [
                'id' => $this->primaryKey()->unsigned(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'name' => $this->string(255)->notNull(),
                'url' => $this->string(255)->notNull(),
                'created_at' => $this
                    ->timestamp()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
            ]
        );

        $this->addForeignKey(
            'fk-task_files-task_id',
            'task_files',
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
        $this->dropForeignKey('fk-task_files-task_id', 'task_files');

        $this->dropTable('task_files');
    }
}
