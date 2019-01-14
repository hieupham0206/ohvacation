<?php

namespace backend\models\base;

use backend\models\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "module_child".
 *
 * @property integer $id
 * @property string $name
 * @property string $controller
 * @property string $role
 * @property integer $module_id
 *
 * @property Module $module
 */
class ModuleChildBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'string'],
            [['module_id'], 'required'],
            [['module_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['controller'], 'string', 'max' => 50],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }
}
