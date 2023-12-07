<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\PermisosHelpers;

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');


/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$muestra_esta_nav = PermisosHelpers::requerirMinimoRol('SuperUsuario');

$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view"  style="margin-left: 20%;"> 

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    <?php if (!Yii::$app->user->isGuest && $muestra_esta_nav) {
      echo Html::a('Update', ['update', 'id' => $model->id], 
                             ['class' => 'btn btn-primary']);}?>
 
    <?php if (!Yii::$app->user->isGuest && $muestra_esta_nav) {
        echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
            ],
            ]);}?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'perfilLink', 'format'=>'raw'],

            'id',
            //'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'rolNombre',
            'estadoNombre',
            'tipoUsuarioNombre',
            'created_at',
            'updated_at',
            //'verification_token',
        ],
    ]) ?>

</div>


<div class="sidebar2">
             <?= Html::a('Usuarios', ['user/index'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Registrar Usuarios', ['site/signup'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Movimientos', ['movimientos/index'], ['class' => 'btn btn-menu']) ?>
            <?= Html::a('Productos Agotados', ['productos/agotados'], ['class' => 'btn btn-menu']) ?>

            <?= Html::a('Caja', ['create'], ['class' => 'btn btn-menu']) ?>
        </div>

