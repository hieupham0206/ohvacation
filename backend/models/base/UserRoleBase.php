<?php

namespace backend\models\base;
use yii\db\ActiveRecord;
use backend\models\query\UserRoleQuery;
use backend\models\User;
use backend\models\Role;


/**
* This is the model class for table "user_role".
*
* @property integer $id
* @property integer $user_id
* @property integer $role_id
* @property integer $status
*
* @property User $user
* @property Role $role
*/
class UserRoleBase extends ActiveRecord {
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['user_id', 'role_id'], 'required'],
            [['user_id', 'role_id', 'status'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']]
        ];
    }


    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
    /**
    * @inheritdoc
    * @return UserRoleQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new UserRoleQuery(get_called_class());
    }
}
