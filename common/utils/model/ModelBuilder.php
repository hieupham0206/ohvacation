<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 3/6/2017
 * Time: 11:20 AM
 */

namespace common\utils\model;

use common\utils\helpers\ArrayHelper;
use common\utils\helpers\StringHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class ModelBuilder
 * @package backend\utilities\model
 */
class ModelBuilder
{
    public $mainModelId;
    public $subModel;
    public $subDetailModel;
    public $subForeignKey;
    public $relation;
    public $subRelation;

    public function __construct($mainModelId)
    {
        $this->mainModelId = $mainModelId;
    }

    /**
     * @param mixed $subModel
     *
     * @return ModelBuilder
     */
    public function setSubModel($subModel)
    {
        $this->subModel = $subModel;

        return $this;
    }

    /**
     * @param mixed $subDetailModel
     *
     * @return ModelBuilder
     */
    public function setSubDetailModel($subDetailModel)
    {
        $this->subDetailModel = $subDetailModel;

        return $this;
    }

    /**
     * @param mixed $subForeignKey
     *
     * @return ModelBuilder
     */
    public function setSubForeignKey($subForeignKey)
    {
        $this->subForeignKey = $subForeignKey;

        return $this;
    }

    /**
     * @param mixed $relation
     *
     * @return ModelBuilder
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @param mixed $subRelation
     *
     * @return ModelBuilder
     */
    public function setSubRelation($subRelation)
    {
        $this->subRelation = $subRelation;

        return $this;
    }

    /**
     * @param ActiveRecord $modelClass
     * @param array $multipleModels
     * @param array $subModels
     *
     * @return array
     */
    public static function createMultiple($modelClass, array $multipleModels = array(), array $subModels = array())
    {
        /** @var ActiveRecord $model */
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if ( ! empty($multipleModels)) {
            $keys           = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }
        if ( ! empty($subModels)) {
            $post = $subModels;
        }
        if ($post && is_array($post)) {
            /** @var array $post */
            foreach ($post as $item) {
                if (isset($item['id']) && ! empty($item['id']) && (isset($multipleModels[$item['id']]) || ! empty($subModels))) {
                    if ( ! empty($multipleModels)) {
                        $models[] = $multipleModels[$item['id']];
                    } else {
                        $model             = $modelClass::findOne(['id' => $item['id']]);
                        $model->attributes = $subModels[0];
                        $models[]          = $model;
                    }
                } else {
                    if ($item !== null) {
                        $models[] = new $modelClass;
                    }
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    /**
     * @param array $configs
     *
     * @return array
     */
    public static function initSubModel(array $configs = array())
    {
        list($modelId, $model, $subModel, $relation) = $configs;
        if ( ! empty($modelId)) {
            $subModelClass    = $subModel::className();
            $modelsAttributes = $model->$relation;
            $oldIDs           = ArrayHelper::map($modelsAttributes, 'id', 'id');
            $modelsAttributes = self::createMultiple($subModelClass, $modelsAttributes);

            $subModels = Yii::$app->request->post(StringHelper::basename($subModel));
            $subModels = $subModels != null ? array_values($subModels) : [];
            foreach ($subModels as $i => $subModelClient) {
                $modelsAttributes[$i]->setAttributes($subModelClient);
            }
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($subModels, 'id', 'id')));

            return array($modelsAttributes, $deletedIDs, $oldIDs);
        }

        $modelsAttributes = self::createMultiple($subModel::className());
        self::loadMultiple($modelsAttributes, Yii::$app->request->post());

        return array($modelsAttributes, [], []);
    }

}