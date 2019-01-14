<?php
namespace backend\components;

use backend\models\Role;
use backend\models\UserRole;
use Yii;
use yii\base\Component;

/**
 * Class Permission
 * @package backend\components
 *
 * @property mixed $listPermissions
 * @property mixed $listPermission
 */
class Permission extends Component
{
    /**
     * @param $controller
     * @param $action
     *
     * @return bool
     */
    public function can($controller, $action)
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($action == 'index') {
            $action = 'view';
        }
        if (strpos($action, '-') !== false) {
            $action = explode('-', $action)[0];
        }
        $key = $action . '_' . $controller;

        $roles = $this->getListPermission();

        return $roles != null ? (bool)$roles[$key] : false;
    }

    /**
     * @return mixed
     */
    private function getListPermission()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $roleId = Yii::$app->user->identity->role_id;
        if (empty($roleId)) {
            return null;
        }

        $role = null;
        if (Yii::$app->cache->exists('permission_' . $roleId)) {
            $role = Yii::$app->cache->get('permission_' . $roleId);
        } else {
            $role = Role::find()->equalTo('id', $roleId)->active()->select(['role'])->one();
            if (empty($role)) {
                $role = null;
            } else {
                Yii::$app->cache->set('permission_' . $roleId, $role, 3600);
            }
        }

        return $role != null ? get_object_vars(json_decode($role->role)) : null;
    }

    /**
     * @param $controller
     * @param $action
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function cans($controller, $action)
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($action == 'index') {
            $action = 'view';
        }
        if (strpos($action, '-') !== false) {
            $action = explode('-', $action)[0];
        }
        $key = $action . '_' . $controller;

        $roles = $this->getListPermissions();

        if ( ! empty($roles)) {
            /** @var array $roles */
            foreach ($roles as $role) {
                if ($role[$key]) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return mixed
     * @throws \yii\db\Exception
     */
    private function getListPermissions()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $userId      = Yii::$app->user->identity->id;
        $roleIds     = UserRole::find()->equalTo('status', 1)->equalTo('user_id', $userId)->select(['role_id'])->createCommand()->queryColumn();
        $permissions = [];
        foreach ($roleIds as $roleId) {
            if (Yii::$app->cache->exists('permission_' . $roleId)) {
                $role = Yii::$app->cache->get('permission_' . $roleId);
            } else {
                /** @var Role $role */
                $role = Role::find()->active()->equalTo('id', $roleIds)->select(['role'])->one();
                Yii::$app->cache->set('permission_' . $roleId, $role, 3600);
            }
            $permissions[] = get_object_vars(json_decode($role->role));
        }

        return ! empty($permissions) ? $permissions : null;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        if (Yii::$app->user->identity == null) {
            return false;
        }
        return Yii::$app->user->identity->username == 'admin' || Yii::$app->user->identity->type == 1;
    }
}