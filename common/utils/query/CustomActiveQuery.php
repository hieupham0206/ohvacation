<?php

namespace common\utils\query;

use yii\db\ActiveQuery;

class CustomActiveQuery extends ActiveQuery
{
    /**
     * @return CustomActiveQuery
     */
    public function createdBy()
    {
        $this->andWhere(['created_by' => \Yii::$app->user->id]);

        return $this;
    }

    /**
     * @param int $type
     * @param string $tableName
     *
     * @return CustomActiveQuery
     */
    public function status($type = 1, $tableName = '')
    {
        $this->andWhere([$tableName . 'status' => $type]);

        return $this;
    }

    /**
     * @param $id int
     *
     * @return CustomActiveQuery
     */
    public function findOneActive($id)
    {
        $this->andWhere(['status' => 1, 'id' => $id]);

        return $this;
    }

    /**
     * @param int $id
     * @param string $tableName
     *
     * @return CustomActiveQuery
     */
    public function id($id = 1, $tableName = '')
    {
        $this->andWhere([$tableName . 'id' => $id]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     *
     * @return CustomActiveQuery
     */
    public function likeTo($column, $operand)
    {
        $this->andFilterWhere(['like', $column, $operand]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     *
     * @return $this
     */
    public function equalTo($column, $operand)
    {
        $this->andFilterWhere([$column => $operand]);

        return $this;
    }

    /**
     * @param $operand
     * @param $operand2
     *
     * @return CustomActiveQuery
     */
    public function orTo($operand, $operand2)
    {
        $this->andFilterWhere(['or', $operand, $operand2]);

        return $this;
    }

    /**
     * @param $operand
     * @param $operand2
     *
     * @return CustomActiveQuery
     */
    public function andTo($operand, $operand2)
    {
        $this->andFilterWhere(['and', $operand, $operand2]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     *
     * @return CustomActiveQuery
     */
    public function in($column, $operand)
    {
        $this->andFilterWhere(['in', $column, $operand]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     * @param $operand2
     *
     * @return CustomActiveQuery
     */
    public function between($column, $operand, $operand2)
    {
        $this->andFilterWhere(['between', $column, $operand, $operand2]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     *
     * @return CustomActiveQuery
     */
    public function notTo($column, $operand)
    {
        $this->andFilterWhere(['not', [$column => $operand]]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     *
     * @return CustomActiveQuery
     */
    public function notIn($column, $operand)
    {
        $this->andFilterWhere(['not in', $column, $operand]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     *
     * @return CustomActiveQuery
     */
    public function notLike($column, $operand)
    {
        $this->andFilterWhere(['not like', $column, $operand]);

        return $this;
    }

    /**
     * @param $column
     * @param $operand
     * @param $operand2
     *
     * @return CustomActiveQuery
     */
    public function notBetween($column, $operand, $operand2)
    {
        $this->andFilterWhere(['not between', $column, $operand, $operand2]);

        return $this;
    }

    /**
     * @param array $columns
     *
     * @param array $excluded
     *
     * @return $this
     */
    public function selectMin(array $columns = array(), array $excluded = ['status', 'created_by', 'created_date', 'updated_date', 'updated_by'])
    {
        $this->select(array_diff($columns, $excluded));

        return $this;
    }
}