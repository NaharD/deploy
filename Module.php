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
			'ranges' => ['13.52.5.0/25', '18.234.32.128/25', '18.205.93.0/25'],
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
