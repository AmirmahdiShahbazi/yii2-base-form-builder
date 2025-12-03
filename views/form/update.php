<?php
use yii\helpers\Html;

$this->title = 'ویرایش فرم: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="form-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>