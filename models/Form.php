<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "forms".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property FormField[] $formFields
 * @property FormSubmission[] $formSubmissions
 */
class Form extends ActiveRecord
{

    public static function tableName()
    {
        return 'forms';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

  
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'], // Required fields
            [['description'], 'string'],      // Text area
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],             // Unique constraint on slug
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'title' => 'عنوان فرم',
            'slug' => 'آدرس (Slug)',
            'description' => 'توضیحات',
            'created_at' => 'تاریخ ایجاد',
            'updated_at' => 'تاریخ ویرایش',
        ];
    }

    public function getFields()
    {
        return $this->hasMany(FormField::class, ['form_id' => 'id'])->orderBy(['ord' => SORT_ASC]);
    }

    public function getSubmissions()
    {
        return $this->hasMany(FormSubmission::class, ['form_id' => 'id']);
    }
}