<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m310103_164545_create_rbac_roles
 */
class m310103_164545_create_rbac_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $roles = [
            'Manager' => 'Менеджер',
            'Client' => 'Клиент',
        ];

        foreach ($roles as $role => $description) {
            if (!$auth->getRole($role)) {
                $role = $auth->createRole($role);
                $role->description = $description;
                $auth->add($role);
            }
        }

        $caseChildren = [
            ['Manager', 'contact/index'],
            ['Manager', 'contact/view'],
            ['Manager', 'contact/update'],
            ['Manager', 'contact/delete'],
            ['Client', 'contact/index'],
            ['Client', 'contact/create'],
        ];

        foreach ($caseChildren as $item) {
            $parent = $auth->getRole($item[0]) ?? $auth->getPermission($item[0]);
            $child = $auth->getPermission($item[1]) ?? $auth->getRole($item[1]);
            if (($auth->canAddChild($parent, $child)) && !($auth->hasChild($parent, $child))) {
                $auth->addChild($parent, $child);
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
