<?php

use backend\models\Productos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

$this->title = 'Productos';

?>
<div class="productos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    
        <?= Html::a('Registrar categoria', ['categoria/create'],['class' => 'custom-button2',]) ?>
        <?= Html::a('Registrar Productos', ['create'],['class' => 'custom-button',]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'custom-table'], // Aplica la clase CSS aquí

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
        [
            'attribute' => 'id',
            'contentOptions' => ['style' => 'width: 130px;'], // Cambia el valor de width según tus necesidades
        ],
        [
            'attribute' => 'nombre',
            'contentOptions' => ['style' => 'width: 190px;'], // Cambia el valor de width según tus necesidades
        ],
           
        [
            'attribute' => 'descripcion',
            'contentOptions' => ['style' => 'width: 160px;'], // Cambia el valor de width según tus necesidades
        ],
        [
            'attribute' => 'stock',
            'contentOptions' => ['style' => 'width: 120px;'], // Cambia el valor de width según tus necesidades
        ],
        [
            'attribute' => 'unidad',
            'contentOptions' => ['style' => 'width: 120px;'], // Cambia el valor de width según tus necesidades
        ],
           
            
        [
            'attribute' => 'categoria',
            'contentOptions' => ['style' => 'width: 160px;'], // Cambia el valor de width según tus necesidades
        ],
        [
            'attribute' => 'precio_costo',
            'value' => function ($model) {
                return '$' . $model->precio_costo;
            },
        ],
        [
            'attribute' => 'precio_venta',
            'value' => function ($model) {
                return '$' . $model->precio_venta;
            },
        ],
 
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Productos $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
            'template' => '{view} {update} {delete}', // Botones de "ver", "editar" y "eliminar"
            'contentOptions' => ['style' => 'width: 200px;'], // Ajusta el ancho según tus necesidades

            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<i class="bx bx-show-alt icono-pequeno"></i>', $url, [
                        'title' => Yii::t('yii', 'Ver'),
                        'class' => 'btn btn-info btn-xs',
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<i class="bx bx-edit icono-pequeno"></i>', $url, [
                        'title' => Yii::t('yii', 'Editar'),
                        'class' => 'btn btn-primary btn-xs',
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<i class="bx bx-trash icono-pequeno"></i>', $url, [
                        'title' => Yii::t('yii', 'Eliminar'),
                        'class' => 'btn btn-danger btn-xs',
                        'data' => [
                            'confirm' => Yii::t('yii', '¿Estás seguro de que quieres eliminar este elemento?'),
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ],
        ],
    ]); ?>


</div>
