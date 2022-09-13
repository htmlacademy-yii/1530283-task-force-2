<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_categories`.
 * Has foreign keys to the tables:
 *
 * - `users`
 * - `categories`
 */
class m220910_094122_create_junction_table_for_users_and_categories_tables extends
    Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'users_categories',
            [
                'user_id' => $this->integer()->unsigned(),
                'category_id' => $this->integer()->unsigned(),
                'PRIMARY KEY(user_id, category_id)',
            ]
        );

        $this->createIndex(
            'idx-users_categories-user_id',
            'users_categories',
            'user_id'
        );

        $this->addForeignKey(
            'fk-users_categories-users_id',
            'users_categories',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-users_categories-category_id',
            'users_categories',
            'category_id'
        );

        $this->addForeignKey(
            'fk-users_categories-category_id',
            'users_categories',
            'category_id',
            'categories',
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
        $this->dropForeignKey(
            'fk-users_categories-users_id',
            'users_categories'
        );

        $this->dropIndex(
            'idx-users_categories-user_id',
            'users_categories'
        );

        $this->dropForeignKey(
            'fk-users_categories-category_id',
            'users_categories'
        );

        $this->dropIndex(
            'idx-users_categories-category_id',
            'users_categories'
        );

        $this->dropTable('users_categories');
    }
}
