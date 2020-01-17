<?php

use yii\db\Migration;

/**
 * Class m200116_211748_create_game_tag
 */
class m200116_211748_create_game_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("game_tag",[ 
            "game_id"=>$this->integer()->notNull(),
            "tag_id"=>$this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('game_tag_pk', 'game_tag', ['game_id','tag_id']);
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
