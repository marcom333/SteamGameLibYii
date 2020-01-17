<?php

use yii\db\Migration;

/**
 * Class m200116_205940_create_category_game
 */
class m200116_205940_create_category_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("category_game",[ 
            "game_id"=>$this->integer()->notNull(),
            "category_id"=>$this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('category_game_pk', 'category_game', ['game_id','category_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_205940_create_category_game cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_205940_create_category_game cannot be reverted.\n";

        return false;
    }
    */
}
