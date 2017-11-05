<?php

namespace nahard\deploy\models;

use Yii;
use yii\base\InvalidParamException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class Deploy extends DeployGii
{
	const STATUS_PROCESSING = -1;
	const STATUS_EXPECTED 	= 0;
	const STATUS_COMPLETED 	= 1;
	const STATUS_REVIEWED 	= 2;
	
	const FILE_NAME_BUILD 				= 'build';
	const FILE_NAME_GIT 				= 'git';
	const FILE_NAME_COMPOSER		 	= 'composer';
	const FILE_NAME_MIGRATE				= 'migrate';
	const FILE_NAME_SCHEDULER_ERROR 	= 'scheduler.error';
	const FILE_NAME_SCHEDULER 			= 'scheduler';
	
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}
	
	static function runDeploy($deployModel=null, $force=null)
	{
		if (!$force) {
			if ($deployModel)
				if (!self::isDeployProcessing())
					$deployModel->makeProcessing();
				else
					return;
		}
		
		$environment	= self::getConfigEnvServer();
		$baseDir 		= self::getConfigBasedir();
		$datetime		= self::formatTimeForLogDir($deployModel->created_by ?? 'now');
		$logDir 		= self::buildLogDir($datetime);
		$buildFile		= Yii::$app->controller->module->buildFile;
		
		if (YII_ENV_DEV) putenv("LD_LIBRARY_PATH=");																// Сраний фікс для ксампа
		
		exec("cd '{$baseDir}'; phing -f {$buildFile} -logfile {$logDir}/build.log -D environment={$environment} -D datetime={$datetime} > {$logDir}/scheduler.log 2>{$logDir}/scheduler.error.log", $output, $return_var); // В $output нічого не буде, все потрапляє в логфайл, але помилку по синтаксису в build.xml відстідкувати можка
		
		if ($return_var === 0)																							// Якщо все файно, буде повернуто значення 0
			Deploy::makeCompletedAll();
		else
			Deploy::makeExpectedAll();
	}
	
	/**
	 * Форматуємо час так, щоб він підходив для назви директорії з логами
	 *
	 * @param string $time
	 * @return string
	 */
	public static function formatTimeForLogDir($time=null)
	{
		return Yii::$app->formatter->asDatetime($time ?? 'now', 'dd.MM.yyyy-HH:mm:ss');
	}
	
	/**
	 * Отримує останній запит від bitbucket
	 *
	 * @return array|Deploy|null|\yii\db\ActiveRecord
	 */
	static function getLastExpectedPush()
	{
		return self::find()->statusExpected()->last()->limit(1)->one();
	}
	
	/**
	 * Формує іконку з кількістю нових здійснених запитав на розгортання
	 * Використовується в лівому меню
	 *
	 * @return string
	 */
	static function getLastUnreadedPush()
	{
		$count = self::find()->statusNotReviewed()->count();
		
		if ($count)
			return '<span class="pull-right-container"><small class="label pull-right bg-green">' . $count . '</small></span></a>';
	}
	
	/**
	 * Перевірка чи в даний момент виконується розгортання
	 *
	 * @return bool
	 */
	static function isDeployProcessing()
	{
		return self::find()->statusProcessing()->exists();
	}
	
	public function isPushReviewed()
	{
		return $this->status != self::STATUS_REVIEWED;
	}
	
	public function makeComplated() {
		return $this->changeStatus(self::STATUS_COMPLETED);
	}
	
	public function makeReviewed() {
		return $this->changeStatus(self::STATUS_REVIEWED);
	}
	
	public function makeProcessing() {
		return $this->changeStatus(self::STATUS_PROCESSING);
	}
	
	public function makeExpected() {
		return $this->changeStatus(self::STATUS_EXPECTED);
	}
	
	public function changeStatus($status)
	{
		$this->scenario = parent::SCENARIO_SCHEDULER;
		$this->status = $status;
		return $this->save();
	}
	
	public static function makeCompletedAll()
	{
		return self::makeStatusAll(self::STATUS_COMPLETED);
	}
	
	public static function makeExpectedAll()
	{
		return self::makeStatusAll(self::STATUS_EXPECTED);
	}
	
	public static function makeStatusAll($status)
	{
		return self::updateAll(['status'=>$status], ['and',
//			['<=', 'id', $this->id],
			['<>', 'status', self::STATUS_REVIEWED],
		]);
	}
	
	static function getConfigBasedir()
	{
		if (!isset(Yii::$app->params['basedir']))
			throw new InvalidParamException("В файлі з конфігурацією не вдалося знайти базової директорії");			// Логуємо помилку та кидаємо виключення
		
		return Yii::$app->params['basedir'];
	}
	
	static function getConfigEnvServer()
	{
		if (!isset(Yii::$app->params['environment']['server']))
			throw new InvalidParamException("В файлі з конфігурацією не вдалося знайти серверного оточення");			// Логуємо помилку та кидаємо виключення
		
		return Yii::$app->params['environment']['server'];
	}
	
	public function populateMessage()
	{
		try {
			$request = Json::decode($this->request_data, false);
		} catch (\Exception $e) {
			$this->message = $e->getMessage();
			return;
		}
		
		if (isset($request->push->changes[0]->commits) && is_array($request->push->changes[0]->commits))
			foreach ($request->push->changes[0]->commits as $commit)
				$this->message .= Html::a("{$commit->type} - {$commit->message}", $commit->links->html->href) . "<br>";
	}
	
	public function getLogFileBuild()
	{
		return $this->getLogFile(self::FILE_NAME_BUILD);
	}
	
	public function getLogFileComposer()
	{
		return $this->getLogFile(self::FILE_NAME_COMPOSER);
	}
	
	public function getLogFileGit()
	{
		return $this->getLogFile(self::FILE_NAME_GIT);
	}
	
	public function getLogFileMigrate()
	{
		return $this->getLogFile(self::FILE_NAME_MIGRATE);
	}
	
	public function getLogFileSchedulerError()
	{
		return $this->getLogFile(self::FILE_NAME_SCHEDULER_ERROR);
	}
	
	public function getLogFileScheduler()
	{
		return $this->getLogFile(self::FILE_NAME_SCHEDULER);
	}
	
	public function getLogFile($fileName)
	{
		$datetime		= Yii::$app->formatter->asDatetime($this->created_at, 'dd.MM.yyyy-HH:mm:ss');
		$logDir 		= self::buildLogDir($datetime) . DIRECTORY_SEPARATOR . $fileName . '.log';
		
		if (is_file($logDir))
			return '<pre>' . file_get_contents($logDir) . '</pre>';
		return "Файлу {$logDir} не знайдено!";
	}
	
	/**
	 * Формуємо відносний шлях до актуальної дипекторії з логами
	 *
	 * @param string $datetime назва поточної директорії для логів
	 * @return string повертається відносний шлях до директорії з поточними логами
	 */
	static function buildLogDir($datetime)
	{
		$logDir = Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . "logs/deploy/{$datetime}";
		
		FileHelper::createDirectory($logDir);
		
		return $logDir;
	}
}
