<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Ventas $model */

$this->title= 'Detalle de venta #'. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ventas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'cliente',
            ],
        ]) ?>

        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha',
        ],
    ]) ?>

    
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $model->detalleVentas,
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_producto',
                'label' => 'Producto',
                'value' => function ($data) {
                    $productos = \backend\models\Productos::findOne($data['id_producto']);
                    return $productos ? $productos->nombre : '';
                },
            ],
            [
                'attribute' => 'id_producto',
                'label' => 'Descripción',
                'value' => function ($data) {
                    $productos = \backend\models\Productos::findOne($data['id_producto']);
                    return $productos ? $productos->descripcion : '';
                },
            ],
            'cantidad',
            'precio_venta',
            'subtotal',
        ],
    ]) ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'usuario',
            
        ],
    ]) ?>


    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                
                'Adeudo',
                'Total',
            ],
        ]) ?>


 

<?php if ($model->adeudo > 0): ?>
    <button type="button" class="btn btn-primary" id="abonar-btn">Abonar</button>
        <?php endif; ?>

</div>
