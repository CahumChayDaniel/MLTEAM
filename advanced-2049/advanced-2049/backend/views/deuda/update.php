<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Deuda $model */

$this->title = 'Update Deuda: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deudas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deuda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
