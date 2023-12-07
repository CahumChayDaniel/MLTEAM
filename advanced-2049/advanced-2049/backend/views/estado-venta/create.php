<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Estadoventa $model */

$this->title = 'Create Estadoventa';
$this->params['breadcrumbs'][] = ['label' => 'Estadoventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoventa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
