<?php

use yii\db\Schema;
use yii\db\Migration;

class m151023_120440_add_news_table extends Migration
{
    public function safeUp()
    {
		$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
	
		$this->createTable('{{%category}}', [
		
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING . ' NOT NULL',
			'title' => Schema::TYPE_STRING . ' NOT NULL',
			
			'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
			
        ], $tableOptions);
		
		$this->createTable('{{%news}}', [
		
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING . ' NOT NULL',
			
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'image' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'short' => Schema::TYPE_STRING . '(1024)  NOT NULL',
            'text'  => Schema::TYPE_TEXT   . ' NOT NULL',
			
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
			
            'views'  => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
			
        ], $tableOptions);
		
		$this->createIndex('index_slug','{{%news}}','slug',true);
		$this->createIndex('index_slug','{{%category}}','slug',true);
		
		$this->addForeignKey('fk_news_category_id','{{%news}}','category_id','{{%category}}','id','CASCADE','CASCADE');
		$this->addForeignKey('fk_news_user_id','{{%news}}','author_id','{{%user}}','id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
		$this->dropIndex('index_slug','{{%news}}');
		$this->dropIndex('index_slug','{{%category}}');
		
        $this->dropForeignKey('fk_news_category_id','{{%news}}');
        $this->dropForeignKey('fk_news_user_id','{{%news}}');
		
        $this->dropTable('{{%news}}');
        $this->dropTable('{{%category}}');
    }
}
