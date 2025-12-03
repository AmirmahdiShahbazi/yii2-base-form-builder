<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "form_submission_values".
 *
 * @property int $id
 * @property int $submission_id
 * @property int $field_id
 * @property string|null $value
 *
 * @property FormField $field
 * @property FormSubmission $submission
 */
class FormSubmissionValue extends ActiveRecord
{
    public static function tableName()
    {
        return 'form_submission_values';
    }

    public function rules()
    {
        return [
            [['submission_id', 'field_id'], 'required'],
            [['submission_id', 'field_id'], 'integer'],
            [['value'], 'string'], // The actual answer text
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'submission_id' => 'شماره درخواست',
            'field_id' => 'فیلد',
            'value' => 'مقدار وارد شده',
        ];
    }

    public function getSubmission()
    {
        return $this->hasOne(FormSubmission::class, ['id' => 'submission_id']);
    }

    public function getField()
    {
        return $this->hasOne(FormField::class, ['id' => 'field_id']);
    }
}