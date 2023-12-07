<?php

use backend\models\Movimientos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\MovimientosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');


$this->title = 'Movimientos';
?>
<div class="movimientos-index" style="margin-left: 250px;"> <!-- Adjust the margin value as needed -->

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registrar Movimiento', ['create'], ['class' => 'custom-button',]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'custom-table'], 

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipo_movimiento',
            'motivo:ntext',
            'monto',
            'usuario',
            'fecha',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Movimientos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>


<div class="sidebar2">
             <?= Html::a('Usuarios', ['user/index'], ['class' => 'btn btn-menu']) ?>

             <?= Html::a('Registrar Usuarios', ['site/signup'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Movimientos', ['movimientos/index'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Productos Agotados', ['productos/agotados'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Caja', ['create'], ['class' => 'btn btn-menu']) ?>
        </div>
