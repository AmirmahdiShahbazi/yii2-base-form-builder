<?php
/** @var yii\widgets\ActiveForm $form */
/** @var yii\base\DynamicModel $model */
/** @var string $attribute */
/** @var app\models\FormField $field */

echo $form->field($model, $attribute)->input('number', ['placeholder' => $field->label]);
?>