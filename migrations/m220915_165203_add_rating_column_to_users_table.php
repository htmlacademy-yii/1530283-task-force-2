<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `users`.
 */
class m220915_165203_add_rating_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'users',
            'rating',
            $this
                ->decimal(3, 2)
                ->defaultValue(0)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'rating');
    }
}
