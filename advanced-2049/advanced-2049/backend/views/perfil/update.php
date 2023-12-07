<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Perfil $model */

$this->title = 'Actualizar el Perfil de: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="perfil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
