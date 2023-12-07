<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var backend\models\Clientes $model */

$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');


$this->title = 'Historial de Deuda';
\yii\web\YiiAsset::register($this);

$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', ['integrity' => 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T', 'crossorigin' => 'anonymous']);
$this->registerJsFile('https://code.jquery.com/jquery-3.3.1.slim.min.js', ['integrity' => 'sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo', 'crossorigin' => 'anonymous']);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', ['integrity' => 'sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM', 'crossorigin' => 'anonymous']);

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="clientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
       
            'cliente',
                 
        ],
    ]) ?>

<div class="contenedor-general">
<div class="ventas-todas-container">

<?php foreach ($ventasCliente as $venta): ?>
    <div class="venta-container">
        <h3>Venta #<?= $venta['id'] ?></h3>

        <?= DetailView::widget([
            'model' => $venta,
            'attributes' => [
                'id',
                'fecha',
                'Total',
                [
                    'label' => 'Monto Pendiente',
                    'value' => Yii::$app->formatter->asCurrency($venta['monto_pendiente']),
                ],
            ],
        ]) ?>

        <?= GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => $detallesVentas[$venta['id']],
            ]),
            'columns' => [
                'id_producto',
                'nombre',
                'descripcion',
                'cantidad',
                'subtotal',
            ],
            'summary' => '',
        ]) ?>

        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary" onclick="abrirModal(<?= $venta['id'] ?>)">
            Abonar
        </button>
        <!-- Modal para el abono -->
        <div class="modal fade" id="modalAbonar<?= $venta['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalAbonarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAbonarLabel">Abonar a Venta #<?= $venta['id'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <label for="montoAbono<?= $venta['id'] ?>">Monto a Abonar:</label>
                        <input type="text" class="form-control" id="montoAbono<?= $venta['id'] ?>">
                        <label for="saldoActual<?= $venta['id'] ?>">Saldo Actual: <?= Yii::$app->formatter->asCurrency($venta['monto_pendiente']) ?></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarAbono(<?= $venta['id'] ?>)">Guardar Abono</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

</div>


<div class="ventas-deuda">
<h3>Detalle de Pago</h3>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Deuda Total',
            'value' => Yii::$app->formatter->asCurrency($deudaTotal),
        ],
    ],
]) ?>

<div class="settle-debt-container">
    <button type="button" class="btn btn-danger" onclick="saldarDeudaTotal()">Saldar Deuda Total</button>
</div>

</div>
</div>
</div>



<script>
    // Esta función abrirá el modal con el ID proporcionado
    function abrirModal(id) {
        $('#modalAbonar' + id).modal('show');
    }


    function guardarAbono(id) {
        var montoAbono = $('#montoAbono' + id).val();

        $.ajax({
            url: 'http://localhost/advanced-2049/advanced-2049/backend/web/index.php?r=deuda/guardar-abono',
            method: 'POST',
            data: { idVenta: id, montoAbono: montoAbono },
            success: function(response) {
                console.log(response);

                if (response.success) {
                // Si es éxito, muestra el mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                });
                location.reload(); // Reload the entire page

            } else {
                // Si es error, muestra el mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }


                $('#modalAbonar' + id).modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                console.log(jqXHR.responseText);
            }
        });
    }

    function saldarDeudaTotal() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esto saldará toda la deuda total. ¿Quieres continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, saldar deuda total',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: 'http://localhost/advanced-2049/advanced-2049/backend/web/index.php?r=deuda/saldar-deuda-total',
                method: 'POST',
                data: { idCliente: <?= $model->id ?> }, // Ajusta según tu lógica
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        // Si es éxito, muestra el mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message,
                        });
                        location.reload(); // O realiza cualquier otra acción después de saldar toda la deuda total
                    } else {
                        // Si es error, muestra el mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });
            }
        });
    }



</script>