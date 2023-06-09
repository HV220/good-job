<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230101_122604_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('ИД'),
            'email' => $this->string()->notNull()->unique()->comment('Электронная почта'),
            'auth_key' => $this->string(32)->notNull()->comment('Ключ аунтификации'),
            'username' => $this->string()->notNull()->comment('Имя'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('Статус'),
            'verification_token' => $this->string()->defaultValue(null)->comment('Токен верификации'),
            'password_hash' => $this->string()->notNull()->comment('Хэш пароля'),
            'password_reset_token' => $this->string()->unique()->comment('Токен сброса пароля'),
            'created_at' => $this->integer()->notNull()->comment('Время создания Клиента'),
            'updated_at' => $this->integer()->notNull()->comment('Время обновления Клиента'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
