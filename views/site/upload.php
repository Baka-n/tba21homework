<?php
/* @var $model app\models\UploadForm*/

use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?php if (Yii::$app->session->hasFlash('fileSuccessfullyProcessed')): ?>
    <div class="alert alert-success">
        <span>Successfully upload</span>
        <p>Processed rows: <?= $_SESSION[fileSuccessfullyProcessed] ?></p>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('fileNotSuccessfullyProcessed')): ?>
    <div class="alert alert-danger">
        <span>Error(s) during upload</span>
        <p>Processed rows: <?= $_SESSION['fileNotSuccessfullyProcessed']['good']?></p>
        <p>Rows with error: <?= $_SESSION['fileNotSuccessfullyProcessed']['badCount'] ?>
        <div>
            <?php
            Modal::begin([
                'header' => 'Problematic test takers, please check (possible duplications)',
                'toggleButton' => ['label' => 'Error details'],
            ]);

            echo $_SESSION['fileNotSuccessfullyProcessed']['bad'];

            Modal::end();
            ?>
        </div> </p>
    </div>

<?php endif; ?>

<?= $form->field($model, 'csvFile')->fileInput() ?>

    <button>Upload CSV</button>

<?php ActiveForm::end() ?>