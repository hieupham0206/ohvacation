<?php

namespace backend\models\query;

use common\utils\query\CustomActiveQuery;

/**
 * This is the ActiveQuery class for [[\backend\models\Role]].
 *
 * @see \backend\models\Role
 */
class RoleQuery extends CustomActiveQuery
{
    /**
     * @return CustomActiveQuery $this
     */
    public function active()
    {
        $this->andWhere(['status' => 1]);

        return $this;
    }

    /**
     * @return CustomActiveQuery $this
     */
    public function visible()
    {
        $this->andWhere(['>=', 'status', 0]);

        return $this;
    }
}
