<?php

use yii\db\Migration;
use yii\db\Schema;

class m151024_181729_add_user_role_field extends Migration
{
    public function up()
    {
		$this->addColumn('{{%user}}','role',Schema::TYPE_INTEGER.' DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('{{%user}}','role');
    }
}
