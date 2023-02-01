<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m999999_999998_mock_create_Manager
 */
class m999999_999998_mock_create_Manager extends Migration
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
                        'managerTest41@yandex.ru',
                        'manager',
                        'Andru',
                        '$2y$13$DlHGpyqt4gLQaTymkGoRR.gPDBKCTDTrB/xarORCVa4WkGJyCJuFC',
                        '0',
                        '0',
                    ],
                ]
            );

            $auth->assign($auth->getRole('Manager'), $this->db->lastInsertID);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
