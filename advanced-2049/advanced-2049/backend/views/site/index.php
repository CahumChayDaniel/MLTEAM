<?php

use yii\helpers\Html;
use common\models\PermisosHelpers;

use yii\helpers\Url;


/** @var yii\web\View $this */

$this->title = 'Sistema XXX';
$es_admin = PermisosHelpers::requerirMinimoRol('Admin');

?>

<div class="site-index">
<div class="container">
    <center>
        <p></p>
        <IMG src=  <?php echo Url::to('@web/archivos/sipvadi.png',true); ?> width="60%" height="40%"  BORDER=0 ALT="Imagen de Enzabezado" ALIGN="center">
        
        <hr>

        <p>
            Descubre SIPVADI, nuestro sólido sistema de punto de venta diseñado para impulsar el éxito de tu negocio. Con una interfaz intuitiva y funciones avanzadas, SIPVADI simplifica la gestión de ventas, inventario y relaciones con los clientes.

            Características destacadas de SIPVADI:
            <ul>
                <li>Registro eficiente de ventas y transacciones.</li>
                <li>Seguimiento en tiempo real del inventario.</li>
                <li>Gestión integral de clientes </li>
                <li>Reportes detallados para tomar decisiones informadas.</li>
                <li>Fácil integración </li>
            </ul>

            ¡Optimiza tus operaciones y lleva tu negocio al siguiente nivel con SIPVADI!
        </p>

            </h4>
        </center>
    </div>
</div>