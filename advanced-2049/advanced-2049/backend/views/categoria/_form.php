<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Categoria $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoria_nombre')->label('Ingresa el nombre de la nueva categoria')->textarea(['rows' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'id'=>'guardard']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
