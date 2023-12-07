<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Estadoventa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estadoventa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'estado_venta')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
