<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nahard\deploy\models\Deploy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deploy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'request_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'request_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'request_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
