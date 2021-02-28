<?php

use practically\chartjs\Chart;
use app\models\TestResults;

if($sum_correct && $sum_incorrect) {
    echo Chart::widget([
        'type' => Chart::TYPE_BAR,
        'datasets' => [
            [
                'data' => [
                    'SUM Correct Answers #'.$sum_correct => [0, $sum_correct],
                    'SUM Incorrect Answers #'.$sum_incorrect => [0, $sum_incorrect]
                ]
            ]
        ]
    ]);

    echo Chart::widget([
        'type' => Chart::TYPE_DOUGHNUT,
        'datasets' => [
            [
                'data' => [
                    'SUM Correct Answers #'.$sum_correct => $sum_correct,
                    'SUM Incorrect Answers #'.$sum_incorrect => $sum_incorrect
                ]
            ]
        ]
    ]);

    echo Chart::widget([
        'type' => Chart::TYPE_PIE,
        'datasets' => [
            [
                'data' => [
                    'AVG Correct Answers #'.$avg_correct => $avg_correct,
                    'AVG Incorrect Answers #'.$avg_incorrect => $avg_incorrect
                ]
            ]
        ]
    ]);

    echo Chart::widget([
        'type' => Chart::TYPE_LINE,
        'datasets' => [
            [
                'data' => [
                    'AVG Correct Answers #'.$avg_correct => $avg_correct,
                    'AVG Incorrect Answers #'.$avg_incorrect => $avg_incorrect
                ]
            ]
        ]
    ]);
} else {
    ?>
    <div class="jumbotron">
        <h1>No data!</h1>

        <p class="lead">Please upload some data!</p>
        <p><a class="btn btn-default" href="/web/site/upload">CSV Upload &raquo;</a></p>
    </div>
<?php } ?>




