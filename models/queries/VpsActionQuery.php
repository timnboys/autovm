<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\VpsAction]].
 *
 * @see \app\models\VpsAction
 */
class VpsActionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\VpsAction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\VpsAction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}