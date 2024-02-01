<?php

namespace nahard\deploy\models;

use Yii;

/**
 * This is the model class for table "deploy".
 *
 * @property integer $id
 * @property string $request_ip
 * @property string $request_data
 * @property string $request_url
 * @property integer $status
 */
class DeployGii extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deploy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_data'], 'string'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => Deploy::STATUS_EXPECTED],
            [['request_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_ip' => 'Ip',
            'message' => 'Message',
            'request_data' => 'Data',
            'request_url' => 'Url',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return DeployQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeployQuery(get_called_class());
    }
}
