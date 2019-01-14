<?php

namespace backend\models;

use backend\models\base\UserBase;
use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $type
 */
class User extends UserBase
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'      => Yii::t('yii', 'Username'),
            'auth_key'      => Yii::t('yii', 'Auth Key'),
            'password_hash' => Yii::t('yii', 'Password'),
            'token'         => Yii::t('yii', 'Token'),
            'email'         => Yii::t('yii', 'Email'),
            'phone'         => Yii::t('yii', 'Phone'),
            'status'        => Yii::t('yii', 'Status'),
            'type'          => Yii::t('yii', 'Type'),
            'role_id'       => Yii::t('yii', 'Role'),
            'created_date'  => Yii::t('yii', 'Created date'),
            'modified_date' => Yii::t('yii', 'Modified date'),
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(),
            [
                [['username', 'email', 'phone'], 'filter', 'filter' => 'trim'],
            ]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ( ! $insert) {
                $this->username = $this->oldAttributes['username'];
            }
            if ($this->password_hash !== '') {
                $this->setPassword($this->password_hash);
            } else {
                $this->password_hash = $this->oldAttributes['password_hash'];
            }

            return true;
        }

        return false;
    }
}
