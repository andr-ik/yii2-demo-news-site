<?php

use yii\db\Migration;
use yii\db\Schema;

class m151024_002109_add_user_activate_field extends Migration
{
    public function up()
    {
		$this->addColumn('{{%user}}','activate_token',Schema::TYPE_STRING.' DEFAULT NULL');
		$this->createIndex('index_activate_token','{{%user}}','activate_token',true);
    }

    public function down()
    {
		$this->dropColumn('{{%user}}','activate_token');
    }
}
