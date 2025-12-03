<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'سامانه فرم‌ساز پویا';
?>
<div class="site-index">

    <div class="p-5 mb-4 bg-light rounded-3 border">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-5 fw-bold text-primary">به سیستم فرم‌ساز خوش آمدید</h1>
            <p class="col-md-8 fs-4 mx-auto text-muted">
                این یک سامانه ساده برای ایجاد و مدیریت فرم‌های پویا است. شما می‌توانید فرم‌های دلخواه خود را بسازید و ورودی‌ها را مدیریت کنید.
            </p>
            <?php if (Yii::$app->user->isGuest): ?>
                <p>
                    <a class="btn btn-primary btn-lg" href="<?= Url::to(['site/login']) ?>">ورود به سیستم &raquo;</a>
                </p>
            <?php else: ?>
                <p class="fw-bold text-success">
                    سلام <?= Html::encode(Yii::$app->user->identity->username) ?>! شما وارد شده‌اید.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <!-- Admin Section -->
            <div class="col-lg-6 mb-4">
                <div class="h-100 p-4 border rounded-3 shadow-sm">
                    <h2>مدیریت فرم‌ها (Admin)</h2>
                    <p>ایجاد، ویرایش و مدیریت فرم‌های سیستم. مخصوص مدیران سیستم.</p>
                    <p>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
                            <a class="btn btn-outline-primary" href="<?= Url::to(['form/index']) ?>">مدیریت فرم‌ها &raquo;</a>
                        <?php else: ?>
                            <span class="text-muted"><small>نیاز به دسترسی ادمین</small></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- User Section -->
            <div class="col-lg-6 mb-4">
                <div class="h-100 p-4 border rounded-3 shadow-sm">
                    <h2>لیست فرم‌های فعال</h2>
                    <p>مشاهده و پر کردن فرم‌هایی که توسط مدیر ایجاد شده‌اند.</p>
                    <p>
                        <a class="btn btn-outline-secondary" href="<?= Url::to(['form/list']) ?>">مشاهده فرم‌ها &raquo;</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>