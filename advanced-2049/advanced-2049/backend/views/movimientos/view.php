<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Movimientos $model */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="movimientos-view" style="margin-left: 25%;">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_tipo',
            'motivo:ntext',
            'monto',
            'user_id',
            'fecha',
        ],
    ]) ?>

</div>

<div class="sidebar2">
             <?= Html::a('Usuarios', ['user/index'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Registrar Usuarios', ['site/signup'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Movimientos', ['movimientos/index'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Productos Agotados', ['productos/agotados'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Caja', ['create'], ['class' => 'btn btn-menu']) ?>
        </div>
