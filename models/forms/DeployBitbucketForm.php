<?php

namespace nahard\deploy\models\forms;

use nahard\deploy\models\Deploy;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;
use Yii;
use yii\web\HttpException;

class DeployBitbucketForm extends DeployForm
{
	public function create()
	{
		$deployModel = new Deploy();
		$deployModel->request_ip 	= Yii::$app->request->userIP;
		$deployModel->request_url 	= Yii::$app->request->absoluteUrl;
		$deployModel->request_data 	= Yii::$app->request->rawBody;
		$deployModel->message 		= $this->getParsedMessage($deployModel->request_data);
		
		if ($deployModel->save())
			return $deployModel;
		
		throw new HttpException('Не вдалося зберегти до БД');
	}
	
	
	public function getParsedMessage($sourceString)
	{
		try {
			$request = Json::decode($sourceString, false);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
		
		$message = '';
		
		if (isset($request->push->changes[0]->commits) && is_array($request->push->changes[0]->commits))
			foreach ($request->push->changes[0]->commits as $commit)
				$message .= "{$commit->type} - " . Html::a($commit->message, $commit->links->html->href, ['target'=>'_blank']) . "<br>";
		
		return $message;
	}
	
	public function getBy(): string
	{
		return 'bitbucket';
	}
}