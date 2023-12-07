<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TipoMovimiento $model */

$this->title = 'Create Tipo Movimiento';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-movimiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
