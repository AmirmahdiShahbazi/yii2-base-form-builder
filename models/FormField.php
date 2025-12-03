<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "form_fields".
 *
 * @property int $id
 * @property int $form_id
 * @property string $label
 * @property string $type
 * @property int|null $required
 * @property string|null $regex
 * @property string|null $options
 * @property int|null $ord
 *
 * @property Form $form
 */
class FormField extends ActiveRecord
{
    public static function tableName()
    {
        return 'form_fields';
    }

    public function rules()
    {
        return [
            [['form_id', 'label', 'type'], 'required', 'message' => '{attribute} نمی‌تواند خالی باشد.' ],
            [['form_id', 'required', 'ord'], 'integer'],
            [['options'], 'string'],
            [['label', 'type', 'regex'], 'string', 'max' => 255],
             ['ord', 'integer', 'min' => 1]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'form_id' => 'فرم مرتبط',
            'label' => 'عنوان فیلد',
            'type' => 'نوع فیلد', // text, number, select, etc.
            'required' => 'اجباری',
            'regex' => 'الگوی اعتبارسنجی (Regex)',
            'options' => 'گزینه‌ها (JSON)', // For dropdowns: ["A", "B"]
            'ord' => 'ترتیب نمایش',
        ];
    }

    public function getOptionsArray()
    {
        $decoded = $this->options ? json_decode($this->options, true) : [];

        if (is_array($decoded) && !empty($decoded)) {
            if (array_keys($decoded) === range(0, count($decoded) - 1)) {
                return array_combine($decoded, $decoded);
            }
        }

        return $decoded;
    }


    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }
}