<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Productos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UM')->dropDownList($model->UmLista, [ 'prompt' => 'Seleccione la unidad de medida' ]);?>

    <?= $form->field($model, 'id_categoria')->dropDownList($model->CategoriaLista, [ 'prompt' => 'Seleccione la categoria a la que pertenece' ]);?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'precio_costo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio_venta')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
