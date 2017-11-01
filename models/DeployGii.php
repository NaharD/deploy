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

	const SCENARIO_SCHEDULER = 'scheduler';
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
            [['request_ip'], 'ip', 'ipv6' => false, 'ranges' => ['104.192.143.0/24', '34.198.203.127', '34.198.178.64', '34.198.32.85', '127.0.0.1'], 'except' => self::SCENARIO_SCHEDULER],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_ip' => 'Request Ip',
            'request_data' => 'Request Data',
            'request_url' => 'Request Url',
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
