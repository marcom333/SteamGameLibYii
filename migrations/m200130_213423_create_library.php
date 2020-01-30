<?php

use yii\db\Migration;

/**
 * Class m200129_213423_create_library
 */
class m200130_213423_create_library extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("library",[ 
            "game_id"=>$this->integer()->notNull(),
            "user_id"=>$this->bigInteger()->notNull(),
        ]);

        $this->addPrimaryKey('library_pk', 'library', ['game_id','user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        echo "m200129_213423_create_library cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_213423_create_library cannot be reverted.\n";

        return false;
    }
    */
}
