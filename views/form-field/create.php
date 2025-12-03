<?php
use yii\helpers\Html;

$this->title = 'افزودن فیلد به: ' . $form->title;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['form/index']];
$this->params['breadcrumbs'][] = ['label' => $form->title, 'url' => ['form/view', 'id' => $form->id]];
$this->params['breadcrumbs'][] = 'افزودن فیلد';
?>
<div class="form-field-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>