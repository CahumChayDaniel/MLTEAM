<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Proveedores $model */

$this->title = 'Registro de Proveedores';

?>
<div class="proveedores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
