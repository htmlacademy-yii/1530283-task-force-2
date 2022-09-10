<?php

use yii\db\Migration;

/**
 * Handles the table `cities` filling with initial data.
 */
class m220910_102958_fill_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents('queries/cities.sql');
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('cities');
    }
}
