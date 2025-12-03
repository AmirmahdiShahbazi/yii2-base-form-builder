<?php
use yii\helpers\Html;

/** @var app\models\Form $formModel */

$this->title = 'ثبت موفق';
?>
<div class="container py-5 text-center">
    <div class="card border-success shadow-sm p-5 mx-auto" style="max-width: 600px;">
        <div class="mb-3 text-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
        </div>
        
        <h2 class="text-success mb-3">اطلاعات با موفقیت ثبت شد!</h2>
        
        <p class="lead text-muted">
            فرم <strong><?= Html::encode($formModel->title) ?></strong> با موفقیت دریافت گردید.
        </p>
        
        <div class="mt-4">
            <?= Html::a('بازگشت به خانه', Yii::$app->homeUrl, ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('ارسال مجدد', ['show', 'slug' => $formModel->slug], ['class' => 'btn btn-link text-decoration-none']) ?>
        </div>
    </div>
</div>