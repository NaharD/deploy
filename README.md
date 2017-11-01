		'deploy' => [
			'class' => 'nahard\deploy\Module',
			'layout' => '@app/modules/control/views/layouts/main',
			'buildFile' => 'build/build.xml',
		],


        'deploy' => [
			'class' => 'nahard\deploy\commands\DeployController',
        ],
