<?php
/* @var $this yii\web\View */

use app\models\libraries\NumberHelper;
use yii\helpers\Url;

$this->title = 'Bài 1';
?>
<div class="ex1-content container py-3">
    <div class="row bg-secondary">
        <div class="col-6 pt-3">
            <div class="alert alert-info mb-0">
                Input
            </div>
            <div class="bg-light p-3 mb-3">
                <?php foreach ($arrInput as $key => $value) : ?>
                    <p><?= $value ?></p>
                <?php endforeach; ?>
                <hr />
                Xem nội dung file tại <a href="<?= Url::toRoute($inputPath) ?>">đây</a>
            </div>
        </div>
        <div class="col-6 pt-3">
            <div class="alert alert-success mb-0">
                Output
            </div>
            <div class="bg-light p-3 mb-3">
                <?php foreach ($arrOutput as $key => $value) : ?>
                    <p><?= $value ?></p>
                <?php endforeach; ?>
                <hr />
                Xem nội dung file tại <a href="<?= Url::toRoute($outputPath) ?>">đây</a>
            </div>
        </div>
    </div>
</div>