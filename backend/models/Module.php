<?php

namespace backend\models;

use backend\models\base\ModuleBase;

class Module extends ModuleBase
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
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
