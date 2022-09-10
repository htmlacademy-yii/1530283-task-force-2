<?php

use yii\db\Migration;

/**
 * Handles the table `categories` filling with initial data.
 */
class m220910_101952_fill_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents('queries/categories.sql');
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('categories');
    }
}
