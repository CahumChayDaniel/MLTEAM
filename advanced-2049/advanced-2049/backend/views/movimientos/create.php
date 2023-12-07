<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Movimientos $model */



$this->title = 'Registro Movimientos';

?>
<div class="movimientos-create" style="margin-left: 250px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
