<?php
/**
 * Rbac.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 16:37
 */

namespace common\models;

use yii\base\BaseObject;
use Yii;

/**
 * Class Rbac
 * Данные о правах доступа
 * @package common\models
 */
class Rbac extends BaseObject
{
    const PERMISSION_ADMIN = 'permission_admin_access';
    const PERMISSION_USER = 'permission_user_access';

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * Создает ролевой доступ
     * @throws \yii\base\Exception
     */
    public function create()
    {
        $this->addRole(self::ROLE_ADMIN, self::PERMISSION_ADMIN, 'All access for admin');
        $this->addRole(self::ROLE_USER, self::PERMISSION_USER, 'Limited access for user');
    }

    /**
     * Создает роль с разрешением
     * @param string $roleName
     * @param string $permissionName
     * @param string $permissionDesc
     * @throws \yii\base\Exception
     */
    protected function addRole($roleName, $permissionName, $permissionDesc)
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionDesc;
        $auth->add($permission);

        $role = $auth->createRole($roleName);
        $auth->add($role);
        $auth->addChild($role, $permission);
    }
}