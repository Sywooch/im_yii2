<?php
use yii\db\Schema;
use yii\db\Migration;
class m160506_062849_create_fav extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%fav}}',
            [
                'id' => Schema::TYPE_PK,
                'user_id' => Schema::TYPE_STRING . '(55) NOT NULL',
                'created_time' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'updated_time' => Schema::TYPE_INTEGER . '(11) NOT NULL'
            ],
            $tableOptions
        );

        $this->createIndex('user_id', '{{%fav}}', 'user_id');
        
        $this->createTable(
            '{{%fav_element}}',
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER . '(55)',
                'model' => Schema::TYPE_STRING . '(110) NOT NULL',
                'fav_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'item_id' => Schema::TYPE_INTEGER . '(55) NOT NULL',
                'count' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'price' => Schema::TYPE_DECIMAL . '(11, 2)',
                'hash' => Schema::TYPE_STRING . '(255) NOT NULL',
            ],
            $tableOptions
        );
       
        $this->createIndex('fav_id', '{{%fav_element}}', 'fav_id');
        
        $this->addForeignKey(
            'elem_to_fav', '{{%fav_element}}', 'fav_id', '{{%fav}}', 'id', 'CASCADE', 'CASCADE'
        );
    }
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%fav_element}}');
        $this->dropTable('{{%fav}}');
    }
}
