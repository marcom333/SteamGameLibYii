<?php

use yii\db\Migration;

/**
 * Class m200116_210018_create_screenshot
 */
class m200116_210018_create_screenshot extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("screenshots",[ 
            "id"=>$this->primaryKey(),
            "game_id"=>$this->integer()->notNull(),
            "path_thumbnail"=>$this->string(512),
        ]);

        //$this->addPrimaryKey('screenshots_pk', 'screenshots', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_210018_create_screenshot cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_210018_create_screenshot cannot be reverted.\n";

        return false;
    }
    */
}
