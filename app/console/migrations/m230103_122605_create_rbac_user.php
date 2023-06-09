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
            'rbac/modules' => 'Страница rbac - полный доступ',
            'contact/index' => 'Страница contact - index',
            'contact/view' => 'Страница contact - view',
            'contact/create' => 'Страница contact - create',
            'contact/update' => 'Страница contact - update',
            'contact/delete' => 'Страница contact - delete',
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
