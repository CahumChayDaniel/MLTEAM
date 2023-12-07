<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DetalleVentas $model */

$this->title = 'Create Detalle Ventas';
$this->params['breadcrumbs'][] = ['label' => 'Detalle Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-ventas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
