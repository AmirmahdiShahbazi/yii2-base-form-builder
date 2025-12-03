<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error container py-5">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger shadow-sm border-0">
                <h2 class="alert-heading text-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i> <?= Html::encode($this->title) ?>
                </h2>
                <hr>
                <p class="lead mb-0">
                    <?= nl2br(Html::encode($message)) ?>
                </p>
            </div>

            <div class="text-muted mt-4">
                <p>
                    خطایی هنگام پردازش درخواست شما رخ داده است.
                </p>
                <p>
                    <?= Html::a('بازگشت به صفحه اصلی', Yii::$app->homeUrl, ['class' => 'btn btn-outline-primary']) ?>
                </p>
            </div>
        </div>
    </div>

</div>