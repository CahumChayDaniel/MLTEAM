<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;  // Asegúrate de tener esto incluido
use yii\web\YiiAsset;



/** @var yii\web\View $this */
/** @var backend\models\Compras $model */

$this->title = 'Detalle de compra #'. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="compras-view">

    <h1><?= Html::encode($this->title) ?></h1>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Proveedor',
            'Nombre',
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
        'allModels' => $model->detalleCompras,
    ]),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'id_producto',
            'label' => 'Producto',
            'value' => function ($data) {
                // Aquí obtienes el modelo de Producto basado en el id_producto
                $productos = \backend\models\Productos::findOne($data['id_producto']);
                // Devuelves el nombre del producto (puedes personalizar según tu modelo)
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
        'precio_compra',
        'subtotal',
    ],
]) ?>

    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                
                'adeudo',
                'total',
            ],
        ]) ?>


 

<?php if ($model->adeudo > 0): ?>
    <button type="button" class="btn btn-primary" id="abonar-btn">Abonar</button>
        <?php endif; ?>

</div>



