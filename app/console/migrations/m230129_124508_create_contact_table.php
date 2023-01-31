<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m230129_124508_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey()->comment('ИД'),
            'title' => $this->string()->notNull()->comment('Тема'),
            'message' => $this->text()->notNull()->comment('Сообщение'),
            'line' => $this->string()->notNull()->comment('Ссылка на файл'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'created_at' => $this->integer()->notNull()->comment('Создано'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлено'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-contact-user_id}}',
            '{{%contact}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-contact-user_id}}',
            '{{%contact}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-contact-user_id}}',
            '{{%contact}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-contact-user_id}}',
            '{{%contact}}'
        );

        $this->dropTable('{{%contact}}');
    }
}
