<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

?>

<div class="user-form" >

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'estado_id',['options' => ['id' => 'estadoact']])->dropDownList($model->estadoLista, [ 'prompt' => 'Por Favor Elija Uno']);?>
 
    <?= $form->field($model, 'rol_id',['options' => ['id' => 'estadoact']])->dropDownList($model->rolLista, [ 'prompt' => 'Por Favor Elija Uno' ]);?>
            
    <?= $form->field($model, 'tipo_usuario_id',['options' => ['id' => 'estadoact']])->dropDownList($model->tipoUsuarioLista, [ 'prompt' => 'Por Favor Elija Uno' ]);?>
    
    <?= $form->field($model, 'username',['options' => ['id' => 'usuario']])->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'email',['options' => ['id' => 'usuario']])->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
    <?= Html::submitButton(
    $model->isNewRecord ? 'Guardar' : 'Actualizar', 
    [
        'id' => 'estadoact', 
        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
    ]
    ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="sidebar2">
             <?= Html::a('Usuarios', ['user/index'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Registrar Usuarios', ['site/signup'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Movimientos', ['movimientos/index'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Productos Agotados', ['productos/agotados'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Caja', ['create'], ['class' => 'btn btn-menu']) ?>
        </div>

       