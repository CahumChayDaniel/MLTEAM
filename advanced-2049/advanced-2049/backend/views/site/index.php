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

       
        </center>
    </div>
</div>