<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m230103_122605_create_rbac_user
 */
class m230103_122605_create_rbac_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $permissions = [
            'user/index' => 'Страница user - просмотр',
            'user/create' => 'Страница user - создание',
            'user/update' => 'Страница user - изменение',
            'user/delete' => 'Страница user - удаление',
            'rbac/modules' => 'Страница rbac - полный доступ',
        ];

        foreach ($permissions as $permission => $description) {
            if (!$auth->getPermission($permission)) {
                $permission = $auth->createPermission($permission);
                $permission->description = $description;
                $auth->add($permission);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
