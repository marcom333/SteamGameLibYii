<?php

use yii\db\Migration;

/**
 * Class m200130_161412_create_user
 */
class m200130_161412_create_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("user",[ 
            "id"=>$this->bigInteger()->notNull(),
            "username"=>$this->string()->notNull(),
            "password"=>$this->string(512)->notNull(),
            'rol'=>$this->integer(),
        ]);
        
        $this->addPrimaryKey('user_pk', 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_161412_create_user cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_161412_create_user cannot be reverted.\n";

        return false;
    }
    */
}
