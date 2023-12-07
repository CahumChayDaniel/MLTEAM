<?php

use backend\models\Ventas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\VentasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');


$this->title = 'Ventas';
?>
<div class="ventas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a('Realizar Venta', ['create'], ['class' => 'custom-button',]) ?>

    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'custom-table'], // Aplica la clase CSS aquí

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha',
            'usuario',
            'cliente',
            [
                'attribute' => 'estado.estado_venta',
                'format' => 'raw',
                'value' => function ($model) {
                    $backgroundColor = '';
                    if ($model->estado->estado_venta === 'Pagado') {
                        $backgroundColor = 'background-color: rgb(11, 165, 11)';
                    } elseif ($model->estado->estado_venta === 'Credito') {
                        $backgroundColor = 'background-color: rgb(185, 4, 4);
                        ';
                    }

                    return '<div class="estado-container" style="' . $backgroundColor . '">' . $model->estado->estado_venta . '</div>';
                },
                'contentOptions' => ['style' => 'white-space: nowrap;'],
            ],
            [
                'attribute' => 'Total',
                'value' => function ($model) {
                    // Agrega el signo de peso al valor de 'Total'
                    return '$' . $model->Total;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Ventas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} ', // Botones de "ver", "editar" y "eliminar"
                'contentOptions' => ['style' => 'width: 130px;'], // Ajusta el ancho según tus necesidades
    
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="bx bx-show-alt icono-pequeno"></i>', $url, [
                            'title' => Yii::t('yii', 'Ver'),
                            'class' => 'btn btn-info btn-xs',
                        ]);
                    },
    
                ],
            ],
        ],
    ]); ?>

</div>
