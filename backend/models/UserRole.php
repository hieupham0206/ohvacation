<?php

namespace backend\models;

use backend\models\base\UserRoleBase;

class UserRole extends UserRoleBase
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'role_id' => 'Role',
            'status'  => 'Status',
        ];
    }

    //	public function beforeSave( $insert ) {
    //		if ( parent::beforeSave( $insert ) ) {
    //			if ( $insert ) {
    //				//nếu là thêm mới
    //			}
    //
    //			return true;
    //		} else {
    //			return false;
    //		}
    //	}
}
