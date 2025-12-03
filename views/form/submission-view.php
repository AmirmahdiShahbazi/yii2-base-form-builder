<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\FormSubmission $submission */

$this->title = 'جزئیات ورودی #' . $submission->id;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $submission->form->title, 'url' => ['view', 'id' => $submission->form_id]];
$this->params['breadcrumbs'][] = ['label' => 'لیست ورودی‌ها', 'url' => ['submissions', 'id' => $submission->form_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submission-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4 class="text-muted mb-4">فرم: <?= Html::encode($submission->form->title) ?></h4>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <strong>اطلاعات ثبت</strong>
        </div>
        <div class="card-body">
            <p><strong>تاریخ ثبت:</strong> <?= Yii::$app->formatter->asDatetime($submission->created_at, 'php:Y/m/d H:i:s') ?></p>
        </div>
    </div>

    <h3 class="mt-4">پاسخ‌ها</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th style="width: 40%">عنوان فیلد</th>
                    <th>مقدار ثبت شده</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submission->values as $value): ?>
                    <tr>
                        <td>
                            <strong><?= Html::encode($value->field->label) ?></strong>
                            <br>
                            <small class="text-muted">(<?= $value->field->type ?>)</small>
                        </td>
                        <td>
                            <?php 
                                // Simple display logic
                                if ($value->value === null || $value->value === '') {
                                    echo '<span class="text-muted font-italic">بدون پاسخ</span>';
                                } else {
                                    echo nl2br(Html::encode($value->value));
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>