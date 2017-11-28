<?php

namespace nahard\deploy\models\forms;

use nahard\deploy\models\Deploy;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;
use Yii;
use yii\web\HttpException;

abstract class DeployForm extends Model
{
	abstract function getBy() : string;
}