<?php

use yii\db\Migration;

/**
 * Class m200121_175240_create_folder_game
 */
class m200130_175240_create_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("data",[ 
            "id"=>$this->primaryKey(),
            "type_id"=>$this->integer()->notNull(),
            "name"=>$this->string(100),
            "user_id"=>$this->bigInteger()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200121_175240_create_folder_game cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200121_175240_create_folder_game cannot be reverted.\n";

        return false;
    }
    */
}
