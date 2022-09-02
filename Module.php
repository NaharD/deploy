<?php

namespace nahard\deploy;

class Module extends \yii\base\Module
{
	
	public $buildFile = 'build/build.xml';
	public $accessRules = [
		[
			'actions' => ['view'],
			'allow' => true,
			'roles' => ['deployView'],
		],
		[
			'actions' => ['index'],
			'allow' => true,
			'roles' => ['deployIndex'],
		],
		[
			'actions' => ['create'],
			'allow' => true,
			'roles' => ['deployCreate'],
		],
		[
			'actions' => ['delete'],
			'allow' => true,
			'roles' => ['deployDelete'],
		],
		[
			'actions' => ['webhook'],
			'allow' => true,
			'roles' => ['deployWebhook'],
		],
	];
	public $ipFilters = [
		'bitbucked' => [
			'class' => 'nahard\deploy\models\forms\DeployBitbucketForm',
			'ranges' => ['34.199.54.113/32', '34.232.25.90/32', '34.232.119.183/32', '34.236.25.177/32', '35.171.175.212/32', '52.54.90.98/32', '52.202.195.162/32', '52.203.14.55/32', '52.204.96.37/32', '34.218.156.209/32', '34.218.168.212/32', '52.41.219.63/32', '35.155.178.254/32', '35.160.177.10/32', '34.216.18.129/32', '3.216.235.48/32', '34.231.96.243/32', '44.199.3.254/32', '174.129.205.191/32', '44.199.127.226/32', '44.199.45.64/32', '3.221.151.112/32', '52.205.184.192/32', '52.72.137.240/32'],
		],
		'manual' => [
			'class' => 'nahard\deploy\models\forms\DeployManualForm',
			'ranges' => ['127.0.0.1'],
		],
	];
	public $phingProgram = 'phing';
	public $viewTabs = [];
	
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		
		// custom initialization code goes here
	}
}
