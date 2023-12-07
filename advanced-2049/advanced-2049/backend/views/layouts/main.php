<?php

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\PermisosHelpers;
use backend\assets\FontAwesomeAsset;
use yii\web\JqueryAsset;
use yii\bootstrap5\BootstrapAsset;
use common\models\User;
use frontend\models\Perfil;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Url;

AppAsset::register($this);
FontAwesomeAsset::register($this);
JqueryAsset::register($this);
BootstrapAsset::register($this);

$this->beginPage();
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::cssFile('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css') ?>
    <?= Html::cssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css') ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block custom-sidebar sidebar">
            <?= Html::submitButton(
                '<i class="bx bx-menu custom-icon menu-icon"></i>',
                ['class' => 'btn hamburguer']
            ) ?>

            <div class="position-sticky">
                <?php
                  $menuItems = [];
                if (!Yii::$app->user->isGuest) {
                    $es_admin = PermisosHelpers::requerirMinimoRol('Admin');
                    $es_Vendedor = PermisosHelpers::requerirMinimoRol('Vendedor');
                    $es_inv = PermisosHelpers::requerirMinimoRol('Inventarista');
                    $id_user = Yii::$app->user->identity->getId();
                    $nombreRol = User::findOne(['id' => $id_user])->rol->rol_nombre;

                  
                    if (!Yii::$app->user->isGuest) {
                        // ... (menú de administración)
                

                     if($es_admin || $es_Vendedor) { 
                       

                    $menuItems[] = ['label' => '<i class="bx bxs-cart-add menu-icon1"></i> Nueva Venta', 'url' => ['/ventas/create'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'P.Agotados'],'encode' => false,];
                        
                    $menuItems[] = ['label' => '<i class="bx bxs-category menu-icon1"></i> Categorias', 'url' => ['/categoria'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Categorias'],'encode' => false,];
                    $menuItems[] = [
                        'label' => '<i class="bx bxs-purchase-tag-alt menu-icon1"></i> Productos',
                        'url' => ['/productos'],
                        'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Productos',
                        ],
                        'encode' => false, 
                    ];


                    $menuItems[] = ['label' => '<i class="bx bxs-truck menu-icon1"></i>Proveedores', 'url' => ['/proveedores'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Proveedores'],'encode' => false, ];
                    $menuItems[] = ['label' => '<i class="bx bxs-user menu-icon1"></i>Clientes', 'url' => ['/clientes'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Clientes'],'encode' => false, ];
                    // Otros elementos del menú de registros...
                    $menuItems[] = ['label' => '<i class="bx bx-dollar menu-icon1"></i>Ventas', 'url' => ['/ventas'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Ventas'],'encode' => false,];
                    $menuItems[] = ['label' => '<i class="bx bxs-shopping-bag menu-icon1"></i>Compras', 'url' => ['/compras'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Compras'],'encode' => false,];
                  
                  if($es_admin){
                    $menuItems[] = ['label' => '<i class="bx bxs-cog menu-icon1"></i>Administración', 'url' => ['/user'], 'options' => ['class' => 'btn btn-menu','data-bs-toggle' => 'popover','data-bs-content' => 'Compras'],'encode' => false,];
                }
                    // Otros elementos del menú de procesos...
                     }
                    }
                }
                ?>
                <?= Nav::widget([
                    'options' => ['class' => 'nav flex-column'],
                    'items' => $menuItems,
                ]); ?>

                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar logout-form']) ?>
                <?= Html::submitButton(
                    '<i class="bx bx-log-out logout-btn-icon"></i> <span class="logout-btn-text">Cerrar Sesión</span>',
                    ['class' => 'btn logout-btn-with-bg']
                ) ?>
                <?= Html::endForm() ?>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main id="main-content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <header>
                <?php
                if (!Yii::$app->user->isGuest) {
                    NavBar::begin([
                        'options' => [
                            'class' => 'navbar navbar-expand-md navbar-dark custom-navbar fixed-top',
                        ],
                    ]);

                    echo '<img src="' . Url::to('@web/archivos/sipvadi.png', true) . '" width="19%" height="23%" BORDER=0 ALT="Imagen de Encabezado" style="float: right; margin-left: 15%;">';

                    echo '<div class="perfil-container">';
                    $usuario = Yii::$app->user->identity;
                    $perfil = Perfil::findOne(['user_id' => $usuario->id]);
                    $iniciales = strtoupper(substr($usuario->username, 0, 1));

                    
                    echo '<span class="navbar-text mr-2 custom-margin-left">' . Html::tag('i', $iniciales, ['class' => 'perfil-icon']) . '</span>';
                    echo '<div class="perfil-usuario">';
                    echo '<div class="nombre-apellido">' . $usuario->username . '</div>';
                    $nombreRol = User::findOne(['id' => $id_user])->rol->rol_nombre;
                    echo '<div class="rol-usuario">' . $nombreRol . '</div>';
                    echo '</div>';
                    
                    echo ButtonDropdown::widget([
                        'label' => false,
                        'options' => ['class' => 'btn btn-primary custom-dropdown'], // Agrega una clase personalizada al botón principal
                        'dropdown' => [
                            'items' => [
                                ['label' => 'Perfil', 'url' => 'http://localhost/advanced-2049/advanced-2049/backend/web/index.php?r=perfil%2Fview', 'options' => ['class' => 'custom-dropdown-item']], 
                                ['label' => 'Link 2', 'url' => '#', 'options' => ['class' => 'custom-dropdown-item']],
                                ['label' => 'Link 3', 'url' => '#', 'options' => ['class' => 'custom-dropdown-item']],
                            ],
                            'options' => ['class' => 'custom-dropdown-menu'], // Agrega una clase personalizada al menú desplegable
                        ],
                    ]);
                    echo '</div>'; 
                    NavBar::end();
                }
                ?>
            </header>

            <main role="main" class="flex-shrink-0">
                <div class="container">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </main>
        </main>
    </div>
</div>

<?php $this->endBody() ?>

<script>
    $(document).ready(function () {
        var sidebarOpened = false;

        function initPopovers() {
            $('[data-bs-toggle="popover"]').popover({
                trigger: 'hover',
                placement: 'right',
            });
        }

        function destroyPopovers() {
            $('[data-bs-toggle="popover"]').popover('dispose');
        }

        $(".hamburguer").click(function () {
            $("#sidebar").toggleClass("sidebar-open");
            $(".logout-btn-text").toggleClass("hide-text");
            $(".logout-btn-icon").toggleClass("increase-size");

            sidebarOpened = !sidebarOpened;

            if (sidebarOpened) {
                initPopovers();
            } else {
                destroyPopovers();
            }

            setTimeout(function () {
                if (sidebarOpened) {
                    $('[data-bs-toggle="popover"]').popover('update');
                }
            }, 300);
        });

        
    });
</script>

</body>
</html>
<?php $this->endPage(); ?>