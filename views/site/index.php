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
            <div class="col-lg-6 text-center">
                <h2>Upload page</h2>
                <p><a class="btn btn-default" href="/web/site/upload">CSV Upload &raquo;</a></p>
            </div>
            <div class="col-lg-6 text-center">
                <h2>Test takers list page</h2>
                <p><a class="btn btn-default" href="/web/site/list">Test Takers &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
