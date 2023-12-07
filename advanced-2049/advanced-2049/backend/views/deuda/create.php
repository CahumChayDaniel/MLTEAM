<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Deuda $model */

$this->title = 'Create Deuda';
$this->params['breadcrumbs'][] = ['label' => 'Deudas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deuda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
