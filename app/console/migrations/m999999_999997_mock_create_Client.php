<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m999999_999997_mock_create_Client
 */
class m999999_999997_mock_create_Client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $this->batchInsert(
            'user',
            ['email', 'auth_key', 'username', 'password_hash', 'created_at', 'updated_at'],
            [
                [
                    'client@mail.ru',
                    'client',
                    'Peter',
                    '$2y$13$DlHGpyqt4gLQaTymkGoRR.gPDBKCTDTrB/xarORCVa4WkGJyCJuFC',
                    '0',
                    '0',
                ],
            ]
        );

        $auth->assign($auth->getRole('Client'), $this->db->lastInsertID);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
