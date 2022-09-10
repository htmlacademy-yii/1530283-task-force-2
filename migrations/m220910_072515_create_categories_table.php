<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m220910_072515_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->unique()->notNull(),
            'icon' => $this->string(255)->unique()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
    }
}
