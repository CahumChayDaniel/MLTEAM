<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Productos $model */

$this->title = 'Registro de Productos';

?>
<div class="productos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
