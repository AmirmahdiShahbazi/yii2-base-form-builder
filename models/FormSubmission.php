<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "form_submissions".
 *
 * @property int $id
 * @property int $form_id
 * @property int|null $created_at
 *
 * @property Form $form
 * @property FormSubmissionValue[] $values
 */
class FormSubmission extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'form_submissions';
    }

    /**
     * Auto-fill created_at timestamp
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id'], 'required'],
            [['form_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'form_id' => 'فرم',
            'created_at' => 'تاریخ ثبت',
        ];
    }

    /**
     * Gets query for [[Form]].
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }

    /**
     * Gets query for [[FormSubmissionValues]].
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(FormSubmissionValue::class, ['submission_id' => 'id']);
    }


    /**
     * Saves the submission header and all related field values in a Transaction.
     * 
     * @param \yii\base\DynamicModel $dynamicModel The model containing the user input (validated)
     * @param FormField[] $fields The array of FormField objects for this form
     * @return bool
     */
    public function saveAnswers($dynamicModel, $fields)
    {
        // 1. Start Database Transaction
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // 2. Save the Submission Header (this model)
            if (!$this->save()) {
                throw new \Exception('خطا در ذخیره اطلاعات اولیه فرم.');
            }

            // 3. Loop through fields and save each value
            foreach ($fields as $field) {
                // The attribute name we generated in the controller (e.g., field_12)
                $attributeName = 'field_' . $field->id;
                
                $valModel = new FormSubmissionValue();
                $valModel->submission_id = $this->id;
                $valModel->field_id = $field->id;
                
                // Get value from DynamicModel and cast to string to be safe
                // (In case of null, it becomes empty string)
                $valModel->value = (string) $dynamicModel->$attributeName;

                if (!$valModel->save()) {
                    throw new \Exception('خطا در ذخیره مقدار فیلد: ' . $field->label);
                }
            }

            // 4. Commit Transaction
            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            // 5. Rollback on Error
            $transaction->rollBack();
            
            // Log the error
            Yii::error($e->getMessage(), __METHOD__);
            
            $this->addError('id', $e->getMessage());
            
            return false;
        }
    }
}