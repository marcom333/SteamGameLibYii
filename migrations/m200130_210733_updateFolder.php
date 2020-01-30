<?php

use yii\db\Migration;

/**
 * Class m200130_210733_updateFolder
 */
class m200130_210733_updateFolder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("folder","user_id",$this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_210733_updateFolder cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_210733_updateFolder cannot be reverted.\n";

        return false;
    }
    */
}
