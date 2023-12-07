<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Um $model */

$this->title = 'Create Um';
$this->params['breadcrumbs'][] = ['label' => 'Ums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="um-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
