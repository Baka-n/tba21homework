<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>
        <p class="lead">Please choose from the options below.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 text-center">
                <h2>Upload page</h2>
                <p><a class="btn btn-default" href="/web/site/upload">CSV Upload &raquo;</a></p>
            </div>
            <div class="col-lg-3 text-center">
                <h2>List page</h2>
                <p><a class="btn btn-default" href="/web/site/list">Test Takers &raquo;</a></p>
            </div>
            <div class="col-lg-3 text-center">
                <h2>Diagrams I</h2>
                <p><a class="btn btn-default" href="/web/site/chart">Chart I &raquo;</a></p>
            </div>
            <div class="col-lg-3 text-center">
                <h2>Diagrams II</h2>
                <p><a class="btn btn-default" href="/web/site/chart-two">Chart II &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
