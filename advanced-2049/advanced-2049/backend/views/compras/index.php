<?php

use backend\models\Compras;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ComprasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');


$this->title = 'Compras';
?>
<div class="compras-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registrar Compra', ['create'], ['class' => 'custom-button',]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'custom-table'], 

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
        [
            'attribute' => 'id',
            'contentOptions' => ['style' => 'width: 130px;'], 
        ],
        [
            'attribute' => 'fecha',
            'contentOptions' => ['style' => 'width: 190px;'], 
        ],
           
        [
            'attribute' => 'usuario',
            'contentOptions' => ['style' => 'width: 160px;'], 
        ],
            
        [
            'attribute' => 'proveedor',
            'contentOptions' => ['style' => 'width: 160px;'], 
        ],
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
                'contentOptions' => ['style' => 'white-space: nowrap; width: 190px;'], // Cambia el valor de width según tus necesidades
            ],
            'adeudo',
            'total',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Compras $model, $key, $index, $column) {
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
