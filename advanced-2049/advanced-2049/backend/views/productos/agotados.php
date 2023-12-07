
<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

$this->title = 'Productos Agotados';
?>

<div class="productos-agotados-container" style="margin-left: 20%;"> <!-- Adjust the margin value as needed -->

    <h1 style="margin-left: -20px;"><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $productosAgotados]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nombre',
            'descripcion',
            'precio_costo',
            // Add more columns as needed
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
