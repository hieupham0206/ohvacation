<?php

namespace backend\models\base;

use backend\models\ModuleChild;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "module".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ModuleChild[] $moduleChildren
 */
class ModuleBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleChildren()
    {
        return $this->hasMany(ModuleChild::className(), ['module_id' => 'id']);
    }
}
