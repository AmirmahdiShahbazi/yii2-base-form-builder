<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Form $formModel */
/** @var yii\base\DynamicModel $model */
/** @var app\models\FormField[] $fields */

$this->title = $formModel->title;
?>
<div class="form-show container py-5">
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="text-center mb-5">
                <h1 class="fw-bold text-primary"><?= Html::encode($formModel->title) ?></h1>
                <?php if ($formModel->description): ?>
                    <p class="text-muted fs-5 mt-2"><?= nl2br(Html::encode($formModel->description)) ?></p>
                <?php endif; ?>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">

                    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

                    <?php foreach ($fields as $field): ?>
                        <?php 
                            // 1. Define the attribute name
                            $attribute = 'field_' . $field->id; 
                            
                            // 2. Define the path to the partial view based on field type
                            // e.g., "fields/text", "fields/select"
                            $viewFile = 'fields/' . $field->type;
                        ?>

                        <div class="mb-3 field-container-<?= $field->type ?>">
                            <?php
                            // 3. Check if file exists, otherwise fallback to 'text'
                            // This prevents crashing if you add a new type to DB but forget the file
                            if (file_exists(Yii::getAlias('@app/views/form/' . $viewFile . '.php'))) {
                                echo $this->render($viewFile, [
                                    'form' => $form,
                                    'model' => $model,
                                    'field' => $field,
                                    'attribute' => $attribute
                                ]);
                            } else {
                                // Fallback for unknown types
                                echo $this->render('fields/text', [
                                    'form' => $form,
                                    'model' => $model,
                                    'field' => $field,
                                    'attribute' => $attribute
                                ]);
                            }
                            ?>
                        </div>

                    <?php endforeach; ?>

                    <?php if (empty($fields)): ?>
                        <div class="alert alert-warning text-center">
                            این فرم هنوز هیچ فیلدی ندارد.
                        </div>
                    <?php else: ?>
                        <div class="d-grid gap-2 mt-4">
                            <?= Html::submitButton('ارسال فرم', ['class' => 'btn btn-primary btn-lg']) ?>
                        </div>
                    <?php endif; ?>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>