<?php

use backend\models\Proveedores;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ProveedoresSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

$this->title = 'Proveedores';
?>
<div class="proveedores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registrar Proveedor', ['create'], ['class' => 'custom-button',]) ?>
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
            'attribute' => 'apellido',
            'contentOptions' => ['style' => 'width: 160px;'], // Cambia el valor de width según tus necesidades
        ],
            
        [
            'attribute' => 'empresa',
            'contentOptions' => ['style' => 'width: 210px;'], // Cambia el valor de width según tus necesidades
        ],
                 
        [
            'attribute' => 'telefono',
            'contentOptions' => ['style' => 'width: 180px;'], // Cambia el valor de width según tus necesidades
        ],
       
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Proveedores $model, $key, $index, $column) {
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
