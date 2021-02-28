<?php

use practically\chartjs\Chart;
use app\models\TestResults;
$rows = [];
foreach($data as $test_taker) {
    $rows[$test_taker['test_taker']] = [0, $test_taker['correct_answers']];
}
if($rows) {
echo Chart::widget([
    'type' => Chart::TYPE_BAR,
    'datasets' => [
        [
            'data' => $rows
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
