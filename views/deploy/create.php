<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model nahard\deploy\models\Deploy */

$this->title = 'Create Deploy';
$this->params['breadcrumbs'][] = ['label' => 'Deploys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deploy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
