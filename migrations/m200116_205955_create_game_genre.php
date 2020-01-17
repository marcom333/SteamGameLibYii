<?php

use yii\db\Migration;

/**
 * Class m200116_205955_create_game_genre
 */
class m200116_205955_create_game_genre extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("game_genre",[ 
            "game_id"=>$this->integer()->notNull(),
            "genre_id"=>$this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('game_genre_pk', 'game_genre', ['game_id','genre_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_205955_create_game_genre cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_205955_create_game_genre cannot be reverted.\n";

        return false;
    }
    */
}
