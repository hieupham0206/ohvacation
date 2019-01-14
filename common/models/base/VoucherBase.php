<?php

namespace common\models\base;

use common\models\Orders;
use common\models\query\VoucherQuery;
use common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "voucher".
 *
 * @property integer $id
 * @property string $client_name
 * @property string $companion
 * @property string $phone
 * @property string $email
 * @property string $code
 * @property string $note
 * @property string $survey_code
 * @property integer $created_date
 * @property integer $modified_date
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $status
 *
 * @property User $createdBy
 * @property User $modifiedBy
 */
class VoucherBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'voucher';
    }

    /**
     * @inheritdoc
     * @return VoucherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoucherQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'unique'],
            [['status', 'voucher_type'], 'integer'],
            [['client_name', 'companion', 'phone', 'email', 'code'], 'string', 'max' => 100],
            [['survey_code'], 'string', 'max' => 50],
            [['id'], 'filter', 'filter' => 'intval']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['voucher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by'])->where(['status' => 1]);
    }
}
