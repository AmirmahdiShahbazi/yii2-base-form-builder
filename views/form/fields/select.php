<?php
/** @var yii\widgets\ActiveForm $form */
/** @var yii\base\DynamicModel $model */
/** @var string $attribute */
/** @var app\models\FormField $field */

$options = $field->getOptionsArray();
echo $form->field($model, $attribute)->dropDownList($options, ['prompt' => 'انتخاب کنید...']);
?>