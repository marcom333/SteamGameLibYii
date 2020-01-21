<?php

use yii\db\Migration;

/**
 * Class m200121_174813_crate_folder
 */
class m200121_174813_crate_folder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("folder",[ 
            "id"=>$this->primaryKey(),
            "folder_id"=>$this->integer(),
            "name"=>$this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200121_174813_crate_folder cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200121_174813_crate_folder cannot be reverted.\n";

        return false;
    }
    */
}
