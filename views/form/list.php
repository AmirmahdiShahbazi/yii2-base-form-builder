<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'لیست فرم‌های فعال';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-list container py-4">

    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted">لطفا فرم مورد نظر خود را جهت تکمیل انتخاب کنید.</p>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n<div class='d-flex justify-content-center mt-4'>{pager}</div>",
        'itemOptions' => ['class' => 'col-md-6 col-lg-4 mb-4'], // Bootstrap Grid Classes
        'options' => ['class' => 'row'], // Container Row
        'itemView' => function ($model, $key, $index, $widget) {
            // This anonymous function renders each item
            return '
                <div class="card h-100 shadow-sm border-0 hover-effect">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title fw-bold text-dark">
                            ' . Html::encode($model->title) . '
                        </h4>
                        <div class="card-text text-muted mb-4 flex-grow-1">
                            ' . ($model->description ? Html::encode(mb_substr($model->description, 0, 100)) . '...' : 'بدون توضیحات') . '
                        </div>
                        <a href="' . Url::to(['form/show', 'slug' => $model->slug]) . '" class="btn btn-primary mt-auto">
                            <i class="bi bi-pencil-square"></i> تکمیل فرم
                        </a>
                    </div>
                </div>
            ';
        },
        'emptyText' => '<div class="col-12"><div class="alert alert-info text-center">در حال حاضر فرم فعالی وجود ندارد.</div></div>',
    ]) ?>

</div>