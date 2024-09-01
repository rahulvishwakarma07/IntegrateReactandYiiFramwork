<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'options' => [
                'class' => 'fw-bold navbar-expand-md navbar-dark fixed-top',
                'style' => 'background-color:#0bcc96'  // Background color for the navbar
            ]
        ]);

        // Custom brand HTML with logo and label
        echo '<div class="navbar-brand d-flex align-items-center">';
        echo Html::img('@web/images/image 16.png', ['alt' => 'Healthcare Logo', 'class' => 'navbar-logo ']);  // Logo image
        echo '<span class="navbar-brand-label">Health<span class="text-warning">Care<span></span>';  // Brand label
        echo '</div>';

        // Create the navigation widget
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav mx-auto col-md-6'],  // Center the nav items
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                // Adding 'Signup' and 'Login' or 'Logout' at the end
                Yii::$app->user->isGuest
                ? ['label' => 'Signup', 'url' => ['/site/signup']]
                : '',
                Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'],'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ],
        ]);

        // End the NavBar
        NavBar::end();
        ?>
    </header>

    <!-- JavaScript code for handling logout -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if the logout form is present
            const logoutForm = document.querySelector('form[action="<?= Url::to(['/site/logout']) ?>"]');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function () {
                    // Clear sessionStorage on logout
                    sessionStorage.removeItem('authToken');
                    sessionStorage.removeItem('userId');
                });
            }
        });
    </script>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container-fluid p-0">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <!-- <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container-fluid">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer> -->

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>