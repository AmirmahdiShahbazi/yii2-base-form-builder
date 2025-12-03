<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\FormField;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Form $model */
/** @var yii\data\ActiveDataProvider $fieldDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت فرم‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش تنظیمات فرم', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف فرم', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'آیا از حذف این فرم و تمام داده‌های آن اطمینان دارید؟',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('مشاهده ورودی‌های ثبت شده', ['submissions', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>

        <?= Html::a('مشاهده فرم زنده (کاربر)', ['/form/show', 'slug' => $model->slug], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            'description:ntext',
            'created_at:datetime',
        ],
    ]) ?>

    <hr class="my-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>فیلدهای فرم</h3>
        <?= Html::a('افزودن فیلد جدید', ['form-field/create', 'form_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $fieldDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'label',
            'type',
            'required:boolean',
            'ord',
            [
                'class' => ActionColumn::class,
                'controller' => 'form-field', // Use FormFieldController for actions
                'template' => '{update} {delete}', // Don't show view button for fields
            ],
        ],
    ]); ?>

</div>
