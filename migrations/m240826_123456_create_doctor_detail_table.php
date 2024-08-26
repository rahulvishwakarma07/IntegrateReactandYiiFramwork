<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor_detail}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%doctor}}`
 */
class m240826_123456_create_doctor_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doctor_detail}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'specialization' => $this->string(255)->notNull(),
            'experience_years' => $this->integer()->notNull(),
            'qualification' => $this->string(255)->notNull(),
            'bio' => $this->text(),
            'consultation_fee' => $this->integer()->notNull(),
            'available_days' => $this->string()->notNull(),
            'start_time' => $this->string(5)->notNull(),
            'end_time' => $this->string(5)->notNull(),
        ]);

        // creates index for column `doctor_id`
        $this->createIndex(
            '{{%idx-doctor_detail-doctor_id}}',
            '{{%doctor_detail}}',
            'doctor_id'
        );

        // add foreign key for table `{{%doctor}}`
        $this->addForeignKey(
            '{{%fk-doctor_detail-doctor_id}}',
            '{{%doctor_detail}}',
            'doctor_id',
            '{{%doctor}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%doctor}}`
        $this->dropForeignKey(
            '{{%fk-doctor_detail-doctor_id}}',
            '{{%doctor_detail}}'
        );

        // drops index for column `doctor_id`
        $this->dropIndex(
            '{{%idx-doctor_detail-doctor_id}}',
            '{{%doctor_detail}}'
        );

        $this->dropTable('{{%doctor_detail}}');
    }
}
