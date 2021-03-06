<?php

namespace nahard\deploy\controllers;

use nahard\deploy\models\forms\DeployBitbucketForm;
use nahard\deploy\models\forms\DeployManualForm;
use function Symfony\Component\Debug\Tests\testHeader;
use Yii;
use nahard\deploy\models\Deploy;
use nahard\deploy\models\DeploySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeployController implements the CRUD actions for Deploy model.
 */
class DeployController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
			'access' => [
				'class' => AccessControl::className(),
				'rules' => $this->module->accessRules,
			],
        ];
    }

    /**
     * Lists all Deploy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeploySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deploy model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$modelDeploy = $this->findModel($id);
    	$modelDeploy->makeReviewed();

        return $this->render('view', [
            'model' => $modelDeploy,
        ]);
    }

    /**
     * Creates a new Deploy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$deployModel = (new DeployManualForm)->create();
		$deployModel->runDeploy();
		return $this->redirect('index');
//		echo $deployModel->responseOk();
    }

    /**
     * Updates an existing Deploy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Deploy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionWebhook()
	{
		// Перевірка чи це пост запит
		$ip = Yii::$app->request->userIP;
		
		$deployForm = Deploy::getDeployForm($ip);
		
		if (!$deployForm)
			return Deploy::responseError($ip);
		
		$deployModel = $deployForm->create();
		$deployModel->runDeploy();
		
		return Deploy::responseOk($ip, $deployForm->getBy());
	}

	public function beforeAction($action)
	{
		if ($action->id == 'webhook') {
			$this->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}
    /**
     * Finds the Deploy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deploy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Deploy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
