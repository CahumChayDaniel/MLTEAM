<?php
 
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap5\Accordion;
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 
?>

<div class="user-index">
 
    <h1><?= Html::encode($this->title) ?></h1>
 
     <?php  // echo Collapse::widget(['items' => [
                                            // equivalente a lo de arriba
                                           //  [
                                           //     'label' => 'Search',
                                            //    'content' => $this->render('_search', ['model' => $searchModel]) ,
                                                // open its content by default
                                                //'contentOptions' => ['class' => 'in']
                                           // ],
                                            
                                    //] 
                                   // ]);  
    ?> 

    <?php  echo Accordion::widget([
        'items' => [
            [
                'label' => 'Usuario a Buscar',
                'content' => $this->render('_search', ['model' => $searchModel]),
                'contentOptions' => ['class' => 'in'],
                'options' => [
                    'class' => 'my-accordion-item', // Agrega una clase personalizada para el elemento de acordeón
                ],
            ],
            // Otros elementos de acordeón si los hay
        ],
    ]);
    ?>
    
    <p> </p>

   
           
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'custom-table2'], 

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            //'id',
            ['attribute'=>'userIdLink', 'format'=>'raw'],
            ['attribute'=>'userLink', 'format'=>'raw'],
            ['attribute'=>'perfilLink', 'format'=>'raw'],
           
            'email:email',
            'rolNombre',
            'tipoUsuarioNombre',
            'estadoNombre',
            'created_at',
          
           ['class' => 'yii\grid\ActionColumn'],
           
            
            // 'updated_at',
 
            
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