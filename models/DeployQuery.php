<?php

namespace nahard\deploy\models;

/**
 * This is the ActiveQuery class for [[DeployGii]].
 *
 * @see DeployGii
 */
class DeployQuery extends \yii\db\ActiveQuery
{
    public function statusCompleted()
    {
        return $this->andWhere(['status' => Deploy::STATUS_COMPLETED]);
    }

    public function statusExpected()
    {
        return $this->andWhere(['status' => Deploy::STATUS_EXPECTED]);
    }

    public function statusProcessing()
    {
        return $this->andWhere(['status' => Deploy::STATUS_PROCESSING]);
    }

	public function statusReviewed()
	{
		return $this->andWhere(['status' => Deploy::STATUS_REVIEWED]);
	}

	public function statusNotReviewed()
	{
		return $this->andWhere(['<>', 'status', Deploy::STATUS_REVIEWED]);
	}

    public function last()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }

    public function first()
    {
        return $this->orderBy(['id' => SORT_ASC]);
    }
}
