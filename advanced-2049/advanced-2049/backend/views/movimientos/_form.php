<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Movimientos $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

?>

<div class="movimientos-form" >

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'id_tipo')->dropDownList($model->MovimientosLista, [ 'prompt' => 'Seleccione el tipo de movimiento' ]);?>


<?= $form->field($model, 'motivo')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'monto')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>


<div class="form-field">
    <?php
    $fechaHoraActual = $model->fecha ? Yii::$app->formatter->asDatetime($model->fecha, 'yyyy-MM-dd HH:mm:ss') : date('Y-m-d H:i:s');
    ?>
    <?= $form->field($model, 'fecha')->label('Fecha y Hora')->textInput(['value' => $fechaHoraActual, 'readonly' => true])->hiddenInput(['value' => $fechaHoraActual])->label(false) ?>
</div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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


