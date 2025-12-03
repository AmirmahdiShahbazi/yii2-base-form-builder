<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\FormField $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="form-field-form">

    <?php $form = ActiveForm::begin([
        'id' => 'field-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'inputOptions' => ['class' => 'form-control'], // Standard Bootstrap Input
            'errorOptions' => ['class' => 'text-danger mt-1'], // <--- THIS MAKES IT RED
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php 
            // Note: The ID of this dropdown is automatically '#formfield-type'
            echo $form->field($model, 'type')->dropDownList([
                'text' => 'Text (متن کوتاه)',
                'textarea' => 'Textarea (متن بلند)',
                'number' => 'Number (عدد)',
                'select' => 'Select (لیست کشویی)',
            ], ['prompt' => 'انتخاب نوع فیلد...']); 
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ord')->input('number', ['min' => 1])->hint('عدد کوچکتر بالاتر نمایش داده می‌شود') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'required')->checkbox() ?>
        </div>
    </div>

    <?php 
    // 1. We add a custom CSS class 'regex-box' to the container div of this field
    echo $form->field($model, 'regex', [
        'options' => ['class' => 'mb-3 regex-box'] 
    ])->textInput(['maxlength' => true])->hint('/^09[0-9]{9}$/'); 
    ?>

    <?php 
    // 2. We add a custom CSS class 'options-box' to the container div of this field
    echo $form->field($model, 'options', [
        'options' => ['class' => 'mb-3 options-box']
    ])->textarea(['rows' => 3])
      ->hint('{"m":"مرد", "f":"زن"} '); 
    ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('ذخیره فیلد', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// 3. Register JavaScript to handle the toggling
$script = <<< JS
    function toggleFields() {
        var type = $('#formfield-type').val();

        if (type === 'select') {
            $('.options-box').show(); // Show JSON box
            $('.regex-box').hide();   // Hide Regex box
        } else {
            $('.options-box').hide(); // Hide JSON box
            $('.regex-box').show();   // Show Regex box
        }
    }

    // Bind the function to the dropdown change event
    $('#formfield-type').on('change', toggleFields);

    // Run the function immediately (in case we are editing an existing record)
    toggleFields();
JS;

$this->registerJs($script);
?>