<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index ">

    <div id="hero" class=" border">
        <div className="container text-center position-relative">
            <h1>Empowering Your Health Journey</h1>
            <h2>Expert Care and Guidance Tailored to Your Needs.</h2>
            <button id='get'><?= Html::a('Get Started', ['/react'], ['style' => 'color:white; text-decoration:none']) ?></button>

        </div>
    </div>
</div>