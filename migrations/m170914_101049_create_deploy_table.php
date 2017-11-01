<?php

use yii\db\Migration;

/**
 * Handles the creation of table `deploy`.
 */
class m170914_101049_create_deploy_table extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function up()
	{
		$this->createTable('deploy', [
			'id' => $this->primaryKey(),
			'request_ip' => $this->string(255),
			'request_data' => $this->text(),
			'request_url' => $this->string(255),
			'message' => $this->text(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'status' => $this->integer()->defaultValue(0),
		]);
	}
	
	/**
	 * @inheritdoc
	 */
	public function down()
	{
		$this->dropTable('deploy');
	}
}
