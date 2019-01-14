<?php

namespace backend\models\base;
use yii\db\ActiveRecord;
use backend\models\query\RoleQuery;
use backend\models\User;
use backend\models\UserRole;


/**
* This is the model class for table "role".
*
* @property integer $id
* @property string $name
* @property string $role
* @property integer $created_date
* @property integer $modified_date
* @property integer $status
*
* @property User[] $users
* @property UserRole[] $userRoles
*/
class RoleBase extends ActiveRecord {
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'role';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['role'], 'string'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }


    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['role_id' => 'id']);
    }
    /**
    * @inheritdoc
    * @return RoleQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new RoleQuery(get_called_class());
    }
}
