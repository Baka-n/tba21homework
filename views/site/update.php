<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['id' => 'update-form','data-pjax' => true],
    'enableAjaxValidation'=> true,


]); ?>
<?= $form->field($model, 'test_taker')->textInput() ?>
<?= $form->field($model, 'correct_answers')->textInput() ?>
<?= $form->field($model, 'incorrect_answers')->textInput() ?>

<div class="form-group">

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

</div>


<?php ActiveForm::end(); ?>

