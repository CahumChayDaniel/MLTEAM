<?php
//ESTE CODIGO ES PARA LA VENTANA DE CREACION DE CLIENTES

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Clientes $model */

$this->title = 'Registrar Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
