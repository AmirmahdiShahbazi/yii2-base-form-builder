<?php

use yii\db\Migration;

class m251202_145847_create_form_submission_values_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%form_submission_values}}', [
            'id' => $this->primaryKey(),
            'submission_id' => $this->integer()->notNull(),
            'field_id' => $this->integer()->notNull(),
            'value' => $this->text(),
        ], $tableOptions);

        // Foreign Key: values -> submission
        $this->addForeignKey(
            'fk-sub_values-submission_id',
            '{{%form_submission_values}}',
            'submission_id',
            '{{%form_submissions}}',
            'id',
            'CASCADE'
        );

        // Foreign Key: values -> field
        $this->addForeignKey(
            'fk-sub_values-field_id',
            '{{%form_submission_values}}',
            'field_id',
            '{{%form_fields}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-sub_values-submission_id', '{{%form_submission_values}}');
        $this->dropForeignKey('fk-sub_values-field_id', '{{%form_submission_values}}');
        $this->dropTable('{{%form_submission_values}}');
    }
}