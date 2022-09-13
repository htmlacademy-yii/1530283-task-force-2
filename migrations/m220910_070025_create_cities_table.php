<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cities`.
 */
class m220910_070025_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'cities',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string(255)->notNull()->unique(),
                'latitude' => $this->decimal(9, 7)->notNull(),
                'longitude' => $this->decimal(10, 7)->notNull(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cities');
    }
}
