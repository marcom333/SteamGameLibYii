<?php

use yii\db\Migration;

/**
 * Class m200121_175240_create_folder_game
 */
class m200121_175240_create_folder_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("folder_game",[ 
            "game_id"=>$this->integer()->notNull(),
            "folder_id"=>$this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('folder_game_pk', 'folder_game', ['game_id','folder_id']);
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
