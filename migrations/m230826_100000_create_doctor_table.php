<?php

// migrations/m230826_100000_create_doctor_table.php
use yii\db\Migration;

/**
 * Handles the creation of table `doctor`.
 */
class m230826_100000_create_doctor_table extends Migration
{
    public function up()
    {
        $this->createTable('doctor', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string(60)->notNull(),
            'phone' => $this->string(15)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('doctor');
    }
}
?>