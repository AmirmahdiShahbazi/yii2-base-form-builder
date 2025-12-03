<?php
use yii\helpers\Html;

$this->title = 'ویرایش فیلد: ' . $model->label;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['form/index']];
$this->params['breadcrumbs'][] = ['label' => $model->form->title, 'url' => ['form/view', 'id' => $model->form_id]];
$this->params['breadcrumbs'][] = 'ویرایش فیلد';
?>
<div class="form-field-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>