<?php

use backend\models\Clientes;
use backend\models\search\ClientesSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var backend\models\search\ClientesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

$this->title = 'Clientes';
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registrar Cliente', ['create'],['class' => 'custom-button',]) ?>
    </p>

    <?php
    $dataProvider->query->andWhere(['>=', 'id', 2]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'custom-table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'apellido',
            'telefono',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Clientes $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}', // Botones de "ver", "editar" y "eliminar"
                'contentOptions' => ['style' => 'width: 190px;'], // Ajusta el ancho según tus necesidades

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