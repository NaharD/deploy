<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model nahard\deploy\models\Deploy */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deploys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deploy-view">

    <p>
		<?= Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
    </p>

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_request" data-toggle="tab" aria-expanded="true">Запит</a></li>
            <li class=""><a href="#tab_build" data-toggle="tab" aria-expanded="false">build.log</a></li>
            <li class=""><a href="#tab_composer" data-toggle="tab" aria-expanded="false">composer.log</a></li>
            <li class=""><a href="#tab_git" data-toggle="tab" aria-expanded="false">git.log</a></li>
            <li class=""><a href="#tab_migrate" data-toggle="tab" aria-expanded="false">migrate.log</a></li>
            <li class=""><a href="#tab_scheduler_error" data-toggle="tab" aria-expanded="false">scheduler.error.log</a></li>
            <li class=""><a href="#tab_scheduler" data-toggle="tab" aria-expanded="false">scheduler.log</a></li>
<!--            <li class="dropdown">-->
<!--                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">-->
<!--                    Dropdown <span class="caret"></span>-->
<!--                </a>-->
<!--                <ul class="dropdown-menu">-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>-->
<!--                    <li role="presentation" class="divider"></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>-->
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
						'message:ntext',
						'created_at',
						'updated_at',
						'status',
					],
				]) ?>
            </div>
            <div class="tab-pane" id="tab_build">
                <?=$model->getLogFileBuild()?>
            </div>

            <div class="tab-pane" id="tab_composer">
                <?=$model->getLogFileComposer()?>
            </div>
            <div class="tab-pane" id="tab_git">
				<?=$model->getLogFileGit()?>
            </div>

            <div class="tab-pane" id="tab_migrate">
				<?=$model->getLogFileMigrate()?>
            </div>

            <div class="tab-pane" id="tab_scheduler_error">
				<?=$model->getLogFileSchedulerError()?>
            </div>

            <div class="tab-pane" id="tab_scheduler">
				<?=$model->getLogFileScheduler()?>
            </div>
        </div>
    </div>

</div>
