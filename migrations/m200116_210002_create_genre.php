<?php

use yii\db\Migration;

/**
 * Class m200116_210002_create_genre
 */
class m200116_210002_create_genre extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("genre",[ 
            "id"=>$this->integer()->notNull(),
            "name"=>$this->string(100),
        ]);

        $this->addPrimaryKey('genre_pk', 'genre', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_210002_create_genre cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_210002_create_genre cannot be reverted.\n";

        return false;
    }
    */
}
