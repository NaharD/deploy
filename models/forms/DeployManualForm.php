<?php

namespace nahard\deploy\models\forms;

use nahard\deploy\models\Deploy;
use yii\base\Model;
use Yii;

class DeployManualForm extends Model
{
	public function create()
	{
		$deployModel = new Deploy();
		$deployModel->request_ip 	= Yii::$app->request->userIP;
		$deployModel->request_url 	= Yii::$app->request->absoluteUrl;
		$deployModel->request_data 	= '';
		$deployModel->message 		= $this->getParsedMessage();
		
		if ($deployModel->save())
			return $deployModel;
		
		throw new HttpException('Не вдалося зберегти до БД');
	}
	
	public function getParsedMessage()
	{
		return 'Ручне розгортання';
	}
}