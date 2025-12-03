<?php

use yii\db\Migration;

class m251202_145804_create_form_submissions_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%form_submissions}}', [
            'id' => $this->primaryKey(),
            'form_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        // Foreign Key: form_submissions -> forms
        $this->addForeignKey(
            'fk-form_submissions-form_id',
            '{{%form_submissions}}',
            'form_id',
            '{{%forms}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-form_submissions-form_id', '{{%form_submissions}}');
        $this->dropTable('{{%form_submissions}}');
    }
}