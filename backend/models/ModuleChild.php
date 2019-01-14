<?php

namespace backend\models;

use backend\models\base\ModuleChildBase;

class ModuleChild extends ModuleChildBase
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'       => 'Name',
            'controller' => 'Controller',
            'role'       => 'Role',
            'module_id'  => 'Module ID',
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
