<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Form $formModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'ورودی‌های فرم: ' . $formModel->title;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->title, 'url' => ['view', 'id' => $formModel->id]];
$this->params['breadcrumbs'][] = 'لیست ورودی‌ها';
?>
<div class="form-submissions">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a('بازگشت به تنظیمات فرم', ['view', 'id' => $formModel->id], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'label' => 'شناسه پیگیری',
                'contentOptions' => ['style' => 'width:100px;'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:Y/m/d H:i:s'],
                'label' => 'تاریخ ثبت',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}', // Only show the View button
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('مشاهده پاسخ‌ها', ['submission-view', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']);
                    },
                ],
            ],
        ],
    ]); ?>

</div>