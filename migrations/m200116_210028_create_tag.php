<?php

use yii\db\Migration;

/**
 * Class m200116_210028_create_tag
 */
class m200116_210028_create_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("tag",[ 
            "id"=>$this->integer()->notNull(),
            "name"=>$this->string(100),
        ]);

        $this->addPrimaryKey('tag_pk', 'tag', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_210028_create_tag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_210028_create_tag cannot be reverted.\n";

        return false;
    }
    */
}
