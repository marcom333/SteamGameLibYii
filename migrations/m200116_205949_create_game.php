<?php

use yii\db\Migration;

/**
 * Class m200116_205949_create_game
 */
class m200116_205949_create_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("game",[ 
            "id"=>$this->integer()->notNull(),
            "name"=>$this->string(512),
            "img_icon_url"=>$this->string(100),
            "img_logo_url"=>$this->string(100),
            "required_age"=>$this->integer(),
            "controller_support"=>$this->string(10),
            "detailed_description"=>$this->text(),
            "about_the_game"=>$this->text(),
            "pc_requirements_minimum"=>$this->text(),
            "pc_requirements_recomended"=>$this->text(),
            "developers"=>$this->string(100),
            "publishers"=>$this->string(100),
            "price_currency"=>$this->string(100),
            "initial"=>$this->integer(),
            "platforms"=>$this->string(100),
            "background"=>$this->string(512),
            "temp_genre"=>$this->string(1024),
            "temp_category"=>$this->string(1024),
            "temp_tag"=>$this->string(1024),

        ]);

        $this->addPrimaryKey('game_pk', 'game', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_205949_create_game cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_205949_create_game cannot be reverted.\n";

        return false;
    }
    */
}
