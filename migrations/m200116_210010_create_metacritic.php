<?php

use yii\db\Migration;

/**
 * Class m200116_210010_create_metacritic
 */
class m200116_210010_create_metacritic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("metacritic",[ 
            "id"=>$this->integer()->notNull(),
            "game_id"=>$this->integer()->notNull(),
            "score"=>$this->integer(),
            "url"=>$this->string(512),
        ]);

        $this->addPrimaryKey('metacritic_pk', 'metacritic', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_210010_create_metacritic cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_210010_create_metacritic cannot be reverted.\n";

        return false;
    }
    */
}
