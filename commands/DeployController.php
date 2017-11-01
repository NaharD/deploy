<?php
namespace nahard\deploy\commands;

use nahard\deploy\models\Deploy;

class DeployController extends \yii\console\Controller
{
    public function actionIndex()
    {
		Deploy::runDeploy();
    }
}
