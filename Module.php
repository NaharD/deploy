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
			'roles' => ['deployUpdate'],
		],
		[
			'actions' => ['update'],
			'allow' => true,
			'roles' => ['deployUpdate'],
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
	];
	
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		
		// custom initialization code goes here
	}
}
