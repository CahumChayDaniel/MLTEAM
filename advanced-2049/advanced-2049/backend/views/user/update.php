<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Actualizar usuario: ' . $model->id;
$this->registerCss('
    h1 {
        margin-left: 25%; /* O el valor que desees */
    }
');

?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
