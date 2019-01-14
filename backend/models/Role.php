<?php

namespace backend\models;

use backend\models\base\RoleBase;

class Role extends RoleBase
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'   => 'Tên vai trò',
            'role'   => 'Role',
            'status' => 'Trạng thái',
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
