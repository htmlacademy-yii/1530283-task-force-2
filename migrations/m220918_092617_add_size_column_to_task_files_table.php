<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `task_files`.
 */
class m220918_092617_add_size_column_to_task_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'task_files',
            'size',
            $this
                ->integer()
                ->unsigned()
                ->notNull()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task_files', 'size');
    }
}
