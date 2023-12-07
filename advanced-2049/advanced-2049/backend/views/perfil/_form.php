<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use  yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perfil */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/perfil.css');

?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin(); ?>

    <div id="formulario-contenedor">
    <label id="datos" for="perfil-nombre">Datos</label>

    <div class="form-fields">
        <div class="form-field">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => 45, 'id' => 'nombre']) ?>
        </div>
        <div class="form-field">
            <?= $form->field($model, 'apellido')->textInput(['maxlength' => 45, 'id' => 'apellido']) ?>
        </div>
    </div>
</div>
    <div id="formulario-contenedor2">

    <?php  echo  $form->field($model,'fecha_nacimiento')->widget(DatePicker::className(),[
                                                                        'dateFormat'  =>  'yyyy-MM-dd',
                                                                        'clientOptions'  =>  [
                                                                        'yearRange'  =>  '-115:+0',
                                                                        'changeYear'  =>  true]
                                                        ])  ?>
    <!-- <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>
    * por favor use el formato YYYY-MM-DD -->

    <label id="genero" for="perfil-nombre">Genero</label>

    <?= $form->field($model, 'genero_id')->dropDownList($model->generoLista, ['prompt' => 'Seleccione el genero','id' => 'gen'])->label(false); ?>
    </div>
    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', [
    'class' => $model->isNewRecord ? 'btn btn-success custom-btn' : 'btn btn-primary custom-btn',
]) ?>
 
</div>

    <?php ActiveForm::end(); ?>

</div>