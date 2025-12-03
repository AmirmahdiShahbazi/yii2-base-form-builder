<?php

use yii\db\Migration;

class m251202_145734_create_form_fields_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%form_fields}}', [
            'id' => $this->primaryKey(),
            'form_id' => $this->integer()->notNull(),
            'label' => $this->string()->notNull(),
            'type' => $this->string()->notNull()->comment('text, number, textarea, select'),
            'required' => $this->boolean()->defaultValue(0),
            'regex' => $this->string(),
            'options' => $this->text()->comment('JSON options for select'),
            'ord' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        // Foreign Key: form_fields -> forms
        $this->addForeignKey(
            'fk-form_fields-form_id',
            '{{%form_fields}}',
            'form_id',
            '{{%forms}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Drop FK before table
        $this->dropForeignKey('fk-form_fields-form_id', '{{%form_fields}}');
        $this->dropTable('{{%form_fields}}');
    }
}