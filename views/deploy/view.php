<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model nahard\deploy\models\Deploy */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deploys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Дійсно волієте видалити цей запис?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
<div class="">
    <div class="box-bodyq table-responsive no-padding">
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_request" data-toggle="tab" aria-expanded="true">Запит</a></li>
                <?php foreach ($this->context->module->viewTabs as $tabId => $tabData):?>
                    <li class=""><a href="#tab_<?=$tabId?>" data-toggle="tab" aria-expanded="false"><?=$tabData['title'] ?? $tabData['file']?></a></li>
                <?php endforeach;?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_request">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'request_ip',
                            'request_data:ntext',
                            'request_url:url',
                            'message:raw',
                            'created_at:datetime',
                            'updated_at:datetime',
                            'status',
                        ],
                    ]) ?>
                </div>
                <?php foreach ($this->context->module->viewTabs as $tabId => $tabData):?>
                    <div class="tab-pane" id="tab_<?=$tabId?>">
                        <?=$model->getLogFile($tabData['file'])?>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
