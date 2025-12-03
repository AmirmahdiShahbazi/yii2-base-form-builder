<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'ورود به سیستم';
?>
<div class="site-login container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-5">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">
                    
                    <p class="text-center text-muted mb-4">لطفا برای ورود اطلاعات زیر را تکمیل کنید:</p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                    <?= $form->field($model, 'username')
                        ->textInput(['autofocus' => true, 'placeholder' => 'نام کاربری خود را وارد کنید']) ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput(['placeholder' => 'رمز عبور']) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group mt-4 d-grid">
                        <?= Html::submitButton('ورود', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <div class="card-footer text-muted text-center">
                    <small>Default Admin: <strong>admin</strong> | Pass: <strong>password</strong></small>
                </div>
            </div>
        </div>
    </div>
</div>