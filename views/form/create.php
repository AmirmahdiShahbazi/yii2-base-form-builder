<?php
use yii\helpers\Html;

$this->title = 'ایجاد فرم جدید';
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>