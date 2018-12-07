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
			'ranges' => ['13.55.145.74/32','13.236.225.70/32','13.236.240.90/32','13.236.240.218/32','13.237.22.210/32','13.237.203.34/32','34.198.210.246/32','34.252.194.82/32','35.160.117.30/32','35.162.23.98/32','35.167.86.65/32','104.192.136.0/21','52.8.252.137/32','34.198.211.97/32','34.208.237.45/32','35.161.3.151/32','35.164.29.75/32','35.166.83.147/32','52.214.35.33/32','54.72.233.229/32','34.192.15.175/32','52.9.41.1/32','54.76.3.75/32','103.233.242.0/24','52.8.84.222/32','13.55.123.56/32','13.237.238.24/32','34.198.178.64/32','34.208.39.80/32','35.162.54.42/32','52.63.74.64/32','185.166.140.0/22','52.63.91.5/32','52.215.192.128/25','52.51.80.244/32','34.198.32.85/32','34.198.203.127/32','13.55.180.21/32','13.54.202.141/32','13.52.5.0/25','13.236.8.128/25','18.136.214.0/25','18.184.99.128/25','18.234.32.128/25','18.246.31.128/25','34.208.209.12/32','52.52.234.127/32','18.205.93.0/27','54.77.145.185/32'],
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
