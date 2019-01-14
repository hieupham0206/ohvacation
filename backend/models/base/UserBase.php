<?php

namespace backend\models\base;

use backend\models\query\UserQuery;
use backend\models\UserRole;
use common\models\User;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $token
 * @property string $email
 * @property string $phone
 * @property integer $status
 * @property integer $created_date
 * @property integer $modified_date
 * @property integer $role_id
 * @property integer $type
 *
 * @property UserRole[] $userRoles
 */
class UserBase extends User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'email'], 'required'],
            [['status', 'role_id', 'type'], 'integer'],
            [['username', 'password_hash', 'token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 15],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['token'], 'unique']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['user_id' => 'id'])->where(['status' => 1]);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
