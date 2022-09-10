<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m220910_081514_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'users',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string(255)->notNull(),
                'email' => $this->string(255)->notNull()->unique(),
                'password_hash' => $this->char(60)->notNull(),
                'city_id' => $this->integer()->unsigned()->notNull(),
                'role' => "ENUM('customer', 'contractor') DEFAULT 'customer'",
                'created_at' => $this
                    ->timestamp()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
                'is_contacts_hidden' => $this->boolean()->defaultValue(false),
                'birthdate' => $this->timestamp(),
                'phone_number' => $this->char(11),
                'telegram' => $this->string(64),
                'description' => $this->string(1000),
                'avatar_url' => $this->string(255),
            ]
        );

        $this->addForeignKey(
            'fk-users-city_id',
            'users',
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
    public
    function safeDown()
    {
        $this->dropForeignKey('fk-users-city_id', 'users');

        $this->dropTable('users');
    }
}
