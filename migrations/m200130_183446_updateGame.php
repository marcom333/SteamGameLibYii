<?php

use yii\db\Migration;

/**
 * Class m200130_183446_updateGame
 */
class m200130_183446_updateGame extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("game","update",$this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_183446_updateGame cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_183446_updateGame cannot be reverted.\n";

        return false;
    }
    */
}
