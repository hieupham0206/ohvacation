<?php

namespace common\utils\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class UUIDBehavior extends Behavior
{
    public $column = '';

    /**
     * Override event()
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
        ];
    }

    public function beforeSave()
    {
        if ($this->column !== '') {
            $this->owner->{$this->column} = Yii::$app->security->generateUuidV4();
        }
    }

}
