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
            <div class="contenido" style="background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <p></p>
                <img src="<?php echo Url::to('@web/archivos/sipvadi.png', true); ?>" width="60%" height="40%" BORDER=0 ALT="Imagen de Encabezado" ALIGN="center">
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
            </div>
        </center>
    </div>
</div>