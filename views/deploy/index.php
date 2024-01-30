<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel nahard\deploy\models\DeploySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deploys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deploy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Розгорнути', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'rowOptions' => function ($model) {
			if (!$model->isPushReviewed())
				return ['class' => 'bg-yellow'];
			elseif ($model->isPushError())
				return ['class' => 'bg-red'];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'request_ip',
//            'request_data:ntext',
//            'request_url:url',
            'message:raw',
            'created_at:datetime',
            // 'updated_at',
            // 'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
