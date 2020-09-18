<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\UserAttachments]].
 *
 * @see \common\models\UserAttachments
 */
class UserAttachmentsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\UserAttachments[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\UserAttachments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
