<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <div id="content">
            <div class="main-site-nav">
                 <!-- Navbar-->
                 <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
                    <div class="container-fluid justify-content-between">
                        <!-- Left elements -->
                        <div class="d-flex">
                            <!-- Brand -->
                            <a class="navbar-brand me-2 mb-1 d-flex align-items-center" href="<?= Url::home() ?>">
                                <img src="<?= Url::toRoute('/images/tardis-doctor-who.jpg') ?>" height="50" alt="QuyenNV" loading="lazy" class="rounded-pill" />
                            </a>


                        </div>
                        <!-- Left elements -->

                        <!-- Center elements -->
                        <ul class="navbar-nav flex-row d-none d-md-flex">

                        </ul>
                        <!-- Center elements -->

                        <!-- Right elements -->
                        <ul class="navbar-nav flex-row">
                            <li class="nav-item me-3 me-lg-1">
                                <a class="nav-link d-sm-flex align-items-sm-center" href="<?= Url::toRoute('/generation') ?>">
                                    <strong class="d-none d-sm-block ms-1">Generation Algorithms</strong>
                                </a>
                            </li>
                        </ul>
                        <!-- Right elements -->
                    </div>
                </nav>
                <!-- Navbar -->
            </div>
           
            <div class="container px-0 d-flex main-site-content">
                <?= $content ?>
            </div>
            <footer class="footer d-none">
                <div class="footer-content">
                    <div class="ft-bg-overlay"></div>
                    <div class="container inner">
                        
                    </div>
                </div>
                <div class="copy-right bg-dark text-light text-center">
                    <span>Copyright &copy; <?= date('Y') ?> by QuyenNV</span>
                </div>
            </footer>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>