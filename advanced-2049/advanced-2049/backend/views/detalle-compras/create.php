<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DetalleCompras $model */

$this->title = 'Create Detalle Compras';
$this->params['breadcrumbs'][] = ['label' => 'Detalle Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-compras-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
