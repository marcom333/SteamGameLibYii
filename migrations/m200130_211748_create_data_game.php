<?php

use yii\db\Migration;

/**
 * Class m200116_211748_create_game_tag
 */
class m200130_211748_create_data_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("game_data",[ 
            "game_id"=>$this->integer()->notNull(),
            "data_id"=>$this->integer()->notNull(),
            "type_id"=>$this->integer()->notNull(),
            "user_id"=>$this->bigInteger()->notNull(),
        ]);

        $this->addPrimaryKey('game_data_pk', 'game_data', ['game_id','data_id','type_id','user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_211748_create_game_tag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_211748_create_game_tag cannot be reverted.\n";

        return false;
    }
    */
}
