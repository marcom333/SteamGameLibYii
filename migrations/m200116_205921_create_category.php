<?php

use yii\db\Migration;

/**
 * Class m200116_205921_create_category
 */
class m200116_205921_create_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("category",[ 
            "id"=>$this->integer()->notNull(),
            "name"=>$this->string(100)
        ]);

        $this->addPrimaryKey('category_pk', 'category', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200116_205921_create_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_205921_create_category cannot be reverted.\n";

        return false;
    }
    */
}
