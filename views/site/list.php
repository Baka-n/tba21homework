<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;

?>
<p>Test takers list with results</p>

<p>

    <?= Html::a(Yii::t('app', 'New Test Taker'), null, ['class' => 'btn btn-success modalLink', 'create-url' => Yii::$app->urlManager->createUrl('site/create')]) ?>

</p>

<?php Pjax::begin(['id' => 'pjax-container','clientOptions' => ['method' => 'POST']]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'test_taker',
            'correct_answers',
            'incorrect_answers',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return (Html::a('<span class="glyphicon glyphicon-pencil"></span>', false, [
                            'class' => 'pjax-update-link',
                            'update-url' => Yii::$app->urlManager->createUrl('site/update?id='.$key),
                            'pjax-container' => 'pjax-container',
                            'title' => Yii::t('app', 'Update'),]));
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'pjax-delete-link',
                            'delete-url' => $url,
                            'pjax-container' => 'pjax-container',
                            'title' => Yii::t('yii', 'Delete')
                        ]);
                    }

                ],
            ],
        ]
    ]);
    Pjax::end();
?>
<?php
    Modal::begin([
        'header'=>'<h4>Create Model</h4>',
        'id'=>'create-modal',
        'size'=>'modal-lg'
    ]);

    echo "<div id='createModalContent'></div>";

    Modal::end();
?>
<?php
Modal::begin([
    'header'=>'<h4>Update Model</h4>',
    'id'=>'update-modal',
    'size'=>'modal-lg'
]);

echo "<div id='updateModalContent'></div>";

Modal::end();
?>
