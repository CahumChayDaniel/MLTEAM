<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use  yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var backend\models\Ventas $model */
/** @var yii\widgets\ActiveForm $form */


if (Yii::$app->session->hasFlash('success')) {
    $successMessage = Yii::$app->session->getFlash('success');
    $script = <<< JS
        Swal.fire({
            icon: 'success',
            title: 'La venta se realizo con Exito',
            text: '{$successMessage}',
            onClose: function() {
                // Puedes realizar acciones adicionales después de cerrar SweetAlert si es necesario
            }
        });
JS;
    $this->registerJs($script, yii\web\View::POS_READY); // Ejecutar el script cuando la vista esté lista
    Yii::$app->session->setFlash('success', null);

}

// Verifica si hay un mensaje flash de error
if (Yii::$app->session->hasFlash('error')) {
    $errorMessage = Yii::$app->session->getFlash('error');
    $script = <<< JS
        Swal.fire({
            icon: 'error',
            title: 'Error al realizar la venta',
            text: '{$errorMessage}',
        });
JS;
    $this->registerJs($script, yii\web\View::POS_READY); // Ejecutar el script cuando la vista esté lista
}




$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="ventas-form">
        <!-- INICIO DEL FORMULARIO PARA MODELO VENTAS -------------------->


<?php $form1 = ActiveForm::begin(['id' => 'form1']); ?>

<div class="form-field">
    <?php
    $fechaFormateada = $model->fecha ? Yii::$app->formatter->asDate($model->fecha, 'yyyy-MM-dd') : date('Y-m-d');
    ?>
    <?= $form1->field($model, 'fecha')->label('Fecha de Nacimiento')->textInput(['value' => $fechaFormateada, 'readonly' => true])->hiddenInput(['value' => $fechaFormateada])->label(false) ?>
</div>

    <?= $form1->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>


    <?= $form1->field($model, 'id_cliente', [
            'options' => ['id' => 'buscar'],
        ])->widget(Select2::class, [
                    'data' => $model->ClientesLista, // Utiliza la función definida en el modelo Clientes.
                    'options' => ['placeholder' => 'Seleccione el cliente'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ->label('Cliente')?>

    <?= $form1->field($model, 'Total')->textInput(['maxlength' => true,'id' => 'total-input','style' => 'display: none;']) ->label(false)?>
   
    <?= $form1->field($model, 'productos_data')->textInput(['id' => 'productos-data', 'class' => 'form-control', 'style' => 'display: none;'])->label(false) ?>

    <!-- Modal para el cobro -->
    <div class="modal fade" id="cobrar-modal" tabindex="-1" role="dialog" aria-labelledby="cobrar-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cobrar-modal-label">Cobrar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerr">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Agrega aquí los campos para ingresar datos -->
                        <div class="form-group">
                             <label for="monto-efec">Efectivo recibido:</label>
                             <input type="number" class="form-control" id="monto-efectivo" placeholder="Ingresa el monto recibido">
                            <label for="monto-pag">Monto a pagar:</label>
                            <input type="number" class="form-control" id="monto-pago" placeholder="Ingresa el monto">

                            <label for="monto-cred">Monto a credito:</label>
                            <?= $form1->field($model, 'adeudo', [
                                'template' => "{input}\n{hint}\n{error}",
                                'inputOptions' => [
                                    'id' => 'adeudo',
                                    'class' => 'form-control',
                                    'placeholder' => 'Ingresa el monto',
                                    'readonly' => true, // Agrega esta línea para hacer el campo de adeudo de solo lectura

                                ],
                                'labelOptions' => ['style' => 'display:none;'], // Oculta el label
                            ])->textInput(['maxlength' => true]) ?>

                            <?= $form1->field($model, 'id_estado')->hiddenInput()->label(false) ?>


                            <strong>Total:</strong> <span id="totalmodal">0.00</span>             
                        </div>
                        <strong>Cambio:</strong> <span id="cambio">0.00</span>
        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="submit-form1">Realizar Cobro</button>
                    </div>
                </div>
            </div>
        </div>



            <!-- Agrega el modal en el cuerpo de tu HTML -->
            <div class="modal" tabindex="-1" role="dialog" id="kgModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Peso en KG</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closekg">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="peso">Peso (KG): </label>
                            <input type="number" id="peso" class="form-control" placeholder="Ingrese el peso en KG">
                            <br>
                            <label for="totalkg">Total en KG: <span id="totalkg"></span></label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarkg">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="calcularTotalKG">Calcular Total</button>
                            <button type="button" class="btn btn-primary" id="gkg">Guardar</button>

                        </div>
                    </div>
                </div>
            </div>






    <?php ActiveForm::end(); ?>
      <!------------------------------------------------------------------------------->

    <!-- INICIO DEL FORMULARIO PARA MODELO DETALLE_COMPRAS-->

    <?php $form2 = ActiveForm::begin(['id' => 'form2']); ?>


    <?= $form1->field($model, 'id_producto', [
            'options' => ['id' => 'buscar'],
        ])->widget(Select2::class, [
            'data' => $model->ProductosLista,
            'options' => ['placeholder' => 'Seleccione el producto'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'pluginEvents' => [
                'change' => 'function() {
                    var selectedProduct = $(this).val();
                    var productData = ' . json_encode($model->ProductosLista) . ';
                    var precioVentaField = $("#' . Html::getInputId($model, 'precio_venta') . '");
                    
                    if (selectedProduct in productData) {
                        var datos = productData[selectedProduct].split(" - ");
                        var nombre = datos[0];
                        var precio = datos[2].replace("$", "").trim();
                        precioVentaField.val(precio);
                    } else {
                        precioVentaField.val("");
                    }
                }',
            ],
        ])->label('Buscar Productos') ?>

    <?= $form1->field($model, 'cantidad', ['options' => ['id' => 'cantidad']])
                ->textInput(['type' => 'number']) ?>

    <?= Html::button('', ['class' => 'bx bxs-cart-add menu-icon1', 'id' => 'agregar-producto']) ?>

    <?= $form1->field($model, 'precio_venta')->hiddenInput()->label(false) ?>
    
 <div id="tablaproductos">
    <table class="table" id="selected-products-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Precio Venta</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se agregarán los productos seleccionados mediante JavaScript -->
                </tbody>
            </table>
    </div>

    <div class="navbar-inferior">
      
        <div id="total-container">
            <strong></strong> <span id="total">0.00</span>
        </div>

        <?= Html::button('Cobrar', [
            'class' => 'cobrar-btn',
            'id' => 'cobrar-btn',
            'data-toggle' => 'modal',
            'data-target' => '#cobrar-modal',

        ]) ?>

    
</div>

    <?php ActiveForm::end(); ?>
        </div>

<?php



$js = <<<JS

    //CONTROL DEL MODAL---------------------------------------------

// Código para mostrar el modal al hacer clic en el botón "Cobrar"
$('#cobrar-btn').on('click', function() {
    $('#monto-efectivo').val('');
    $('#monto-pago').val('');
    $('#monto-credito').val('');
    $('#cambio').text('0.00');

    $('#cobrar-modal').modal('show');
   });

   // Código para cerrar
$('#cerrar').on('click', function() {
    $('#monto-efectivo').val('');
    $('#monto-pago').val('');
    $('#monto-credito').val('');
    $('#cambio').text('0.00');
    $('#adeudo').val('');

    $('#cobrar-modal').modal('hide');
   });

   $('#cerr').on('click', function() {
    $('#monto-efectivo').val('');
    $('#monto-pago').val('');
    $('#monto-credito').val('');
    $('#adeudo').val('');
    $('#cambio').text('0.00');
    
    $('#cobrar-modal').modal('hide');

   });

   $('#closekg').on('click', function() {
    $('#peso').val('');
    $('#totalkg').val('');
  
    $('#kgModal').modal('hide');
   });

   $('#cerrarkg').on('click', function() {
    $('#peso').val('');
    $('#totalkg').val('');
  
    $('#kgModal').modal('hide');
   });

   // Código para realizar acciones al hacer clic en el botón "Realizar Cobro"
   $('#realizar-cobro').on('click', function() {
       // Puedes realizar acciones aquí, por ejemplo, enviar datos al servidor
       var montoPago = $('#monto-pago').val();
       console.log('Monto a pagar:', montoPago);


       // Cierra el modal después de realizar el cobro
       $('#cobrar-modal').modal('hide');
   });

   var adeudo = 0;
   // Función para actualizar el total en el modal y el adeudo
   function actualizarTotalEnModal() {
    var montoPago = parseFloat($('#monto-pago').val()) || 0;
    var totalModal = parseFloat($('#totalmodal').text().replace('$', '')) || 0;

    // Asegura que el monto-pago no sea menor que 0
    montoPago = Math.max(0, montoPago);

    // Asegura que el monto-pago no sea mayor que el total
    montoPago = Math.min(totalModal, montoPago);

    // Actualiza el valor de adeudo
    adeudo = totalModal - montoPago;
    $('#adeudo').val(adeudo.toFixed(2));
    
    idtotal();

    // Actualiza el valor de monto-pago en el campo
    $('#monto-pago').val(montoPago.toFixed(2));// Eliminado el .toFixed(2)

  
    if (adeudo>0) {
        // Actualiza el campo de cambio
       actualizarCambio2();
   
    }if (montoEfectivo == montoPago ) {
        var cambio =0 ;

        $('#cambio').text('$' + cambio.toFixed(2));
      

    } 
    
    else{
        // Actualiza el campo de cambio
         actualizarCambio();
   
    }

}

    function actualizarCambio2() {
    
    var montoEfectivo = parseFloat($('#monto-efectivo').val()) || 0;
    var montoPago= parseFloat($('#monto-pago').val()) || 0;

    var cambio = montoEfectivo - montoPago;
    $('#cambio').text('$' + cambio.toFixed(2));
    }

    function idtotal() {
    //actualiza el id_estado
    var id_estado = (adeudo == 0) ? 1 : 2;
    $('#form1 #ventas-id_estado').val(id_estado);
}

   function actualizarCambio() {
  
    var montoEfectivo = parseFloat($('#monto-efectivo').val()) || 0;
    var total = parseFloat($('#totalmodal').text().replace('$', '')) || 0; // Eliminar el signo de dólar
    var cambio = montoEfectivo - total;
    $('#cambio').text('$' + cambio.toFixed(2));
}
    //ENVIAR FORMULARIOS AL CONTROLADOR---------------------------------------------

   $('#submit-form1').on('click', function() {

    // Recopila los datos de la tabla
    var productosData = [];
    $('#selected-products-table tbody tr').each(function() {
        var id_producto = $(this).find('td:eq(0)').text();
        var cantidad = $(this).find('td:eq(3)').text();
        var precio_costo = $(this).find('td:eq(4)').text().replace('$', '');
        var subtotal = $(this).find('td:eq(5)').text().replace('$', '');

        productosData.push({
            id_producto: id_producto,
            cantidad: cantidad,
            precio_compra: precio_costo,
            subtotal: subtotal
        });
    });

    // Agrega los datos al campo oculto en form1
    $('#productos-data').val(JSON.stringify(productosData));

    // Ahora, envía el formulario form1
    $('#form1').submit();
    $('#ventas-id_producto').val('').trigger('change');
    $('#ventas-cantidad').val('');
    $('#ventas-precio_venta').val('');


    
   
});






    //CODIGO PARA PRODUCTOS EN LA TABLA TEMPORAL---------------------------------------------

$(document).ready(function() {
    var selectedProducts = [];
    var table = $('#selected-products-table');
    var totalElement = $('#total');
    var totalElement2 = $('#totalmodal');

    // Función para actualizar el total
    function actualizarTotal() {
        var total = 0;
        selectedProducts.forEach(function(product) {
            total += parseFloat(product.subtotal);
        });
        totalElement.text('$' + total.toFixed(2));
        totalElement2.text('$' + total.toFixed(2));
        
    }

    // Función para buscar un producto en la lista de selectedProducts por su ID
    function buscarProductoPorId(id_producto) {
        for (var i = 0; i < selectedProducts.length; i++) {
            if (selectedProducts[i].id_producto === id_producto) {
                return i;
            }
        }
        return -1;
    }

    // Función para agregar una fila a la tabla
    function agregarFila(id_producto, nombre, descripcion, cantidad, precio_venta, subtotal) {
        var precioVentaConSigno = '$' + precio_venta.toFixed(2);
        var subtotalConSigno = '$' + subtotal.toFixed(2);

        selectedProducts.push({ id_producto: id_producto, nombre: nombre, cantidad: cantidad, precio_venta: precio_venta, subtotal: subtotal });

        var newRow = '<tr><td>' + id_producto + '</td><td>' + nombre + '</td><td>' + descripcion + '</td><td>' + cantidad + '</td><td>' + precioVentaConSigno + '</td><td>' + subtotalConSigno + '</td><td><button class="eliminar-producto">Eliminar</button></td></tr>';

        table.append(newRow);
        actualizarTotal();
    }

    // Agregar producto a la tabla
    $('#agregar-producto').click(function() {
        var id_producto = $('#ventas-id_producto').val();
        var nombre = $('#ventas-id_producto option:selected').text().split(' - ')[0];
        var descripcion = $('#ventas-id_producto option:selected').text().split(' - ')[1];
        var cantidad = parseInt($('#ventas-cantidad').val(), 10);
        var precio_venta = parseFloat($('#ventas-precio_venta').val());
        var stock = obtenerStockDesdeOptionSeleccionada('#ventas-id_producto');
        var unidad = parseFloat($('#ventas-precio_venta').val());
        var um = obtenerUMDesdeOptionSeleccionada('#ventas-id_producto');



        if (stock <= 0) {
            Swal.fire({
                icon: "error",
                title: "Stock Insuficiente",
                text: "El producto seleccionado no esta disponible",
            });
            return; // No agregar a la tabla si el stock es insuficiente
        }


        if (um.toUpperCase() === "KG") {
        // Si la unidad de medida es "KG", abre el modal para ingresar el peso
        $('#kgModal').modal('show');
    } else {

        if (id_producto && !isNaN(cantidad) && !isNaN(precio_venta) && cantidad > 0) {
            if (cantidad < 1) {
                alert('La cantidad no puede ser menor a 1.');
                return;
            }

            var indexProductoExistente = buscarProductoPorId(id_producto);

            if (indexProductoExistente !== -1) {
                // Si el producto ya existe, actualiza la cantidad y el subtotal en la lista
                var existingProducto = selectedProducts[indexProductoExistente];
                existingProducto.cantidad += cantidad;
                var precioVenta = existingProducto.precio_venta;
                existingProducto.subtotal = existingProducto.cantidad * precioVenta;

                // Actualiza la cantidad y el subtotal en la tabla
                var filaExistente = table.find('tr:eq(' + (indexProductoExistente + 1) + ')');
                filaExistente.find('td:eq(3)').text(existingProducto.cantidad);
                filaExistente.find('td:eq(5)').text('$' + existingProducto.subtotal.toFixed(2));
            } else {
                // Si el producto no existe, agrega una nueva fila a la tabla
                var subtotal = cantidad * precio_venta;
                agregarFila(id_producto, nombre, descripcion, cantidad, precio_venta, subtotal);
            }

            // Vacía los campos después de agregar
            $('#ventas-id_producto').val('').trigger('change');
            $('#ventas-cantidad').val('');
            $('#ventas-precio_venta').val('');

            // Actualiza los campos del formulario con el nuevo total
            actualizarTotal();
            ajustarAlturaContenedor()
        } else {
   
           
     
                    Swal.fire({
                    icon: "error",
                    title: "Datos Erróneos",
                    text: "El campo producto o cantidad esta vacio",
                    });
                }
        }
    });
    

    // Manejar el evento de eliminación de productos
    table.on('click', '.eliminar-producto', function() {
        var rowIndex = $(this).closest('tr').index();
        selectedProducts.splice(rowIndex, 1);
        $(this).closest('tr').remove();
        actualizarTotal();
    });


            // JS PARA AGREGAR EL TOTAL SIN SIGNOS A UN INPUT PARA ENVIAR --------------------

            // Obtén el valor inicial del span y elimina el símbolo de peso
            var totalSpan = $('#total');
                    var totalInput = $('#total-input');

                    function updateInputValue() {
                        var totalValue = totalSpan.text().replace('$', '');
                        totalInput.val(totalValue);
                    }

                    // Llama a la función inicialmente para establecer el valor inicial
                    updateInputValue();

                    // Observa cambios en el contenido del span y actualiza el campo de entrada
                    totalSpan.on('DOMSubtreeModified', updateInputValue);

        // -----------------------------------------------------------


        
        $('#monto-efectivo, #monto-credito').on('input', function() {
            
            actualizarCambio(); // Asegúrate de que esta línea esté presente
        });

        $('#monto-pago').on('input', function () {
            actualizarTotalEnModal();
        });

        $('#peso').on('input', function () {
            calcularTotalKG();
        });

        function ajustarAlturaContenedor() {
            var tabla = document.getElementById("selected-products-table");
            var contenedor = document.getElementById("tablaproductos");
            
            // Ajusta la altura del contenedor según la altura de la tabla con un incremento de 10 píxeles
            contenedor.style.height = (tabla.scrollHeight + 30) + "px";
        }


        function obtenerStockDesdeOptionSeleccionada(selectId) {
            var stock = 0;
            var selectedOption = $(selectId + ' option:selected');

            if (selectedOption.length > 0) {
                var stockText = selectedOption.text().split(' - ')[3]; // Ajusta la posición según tu estructura de datos
                stock = parseInt(stockText);
            }

            return stock;
        }

        function obtenerUMDesdeOptionSeleccionada(selectId) {
            var um = '';
            var selectedOption = $(selectId + ' option:selected');

            if (selectedOption.length > 0) {
                um = selectedOption.text().split(' ').pop(); // Obtener la última palabra (UM) asumiendo que está al final
            }

            return um;
        }

        $('#calcularTotalKG').click(function () {
            var peso = parseFloat($('#peso').val());
            var precioPorKG = parseFloat($('#ventas-precio_venta').val());

            if (!isNaN(peso) && !isNaN(precioPorKG)) {
                var totalPrecio = peso * precioPorKG;
                $('#totalkg').text('$' + totalPrecio.toFixed(2));
            } else {
                console.error('Error en la entrada de peso o precio por KG.');
            }
        });


        $('#gkg').click(function () {
    var peso = parseFloat($('#peso').val());
    var precioPorKG = parseFloat($('#ventas-precio_venta').val());

    if (!isNaN(peso) && !isNaN(precioPorKG)) {
        // Obtener el resto de la información necesaria desde los campos ocultos
        var id_producto = $('#ventas-id_producto').val();
        var nombre = $('#ventas-id_producto option:selected').text().split(' - ')[0];
        var descripcion = $('#ventas-id_producto option:selected').text().split(' - ')[1];
        var precio_venta = parseFloat($('#ventas-precio_venta').val());
        var stock = obtenerStockDesdeOptionSeleccionada('#ventas-id_producto');

        var indexProductoExistente = buscarProductoPorId(id_producto);

        if (indexProductoExistente !== -1) {
            // Si el producto ya existe, verifica si la cantidad total supera el stock
            var existingProducto = selectedProducts[indexProductoExistente];
            var cantidadTotal = existingProducto.cantidad + peso;

            if (cantidadTotal > stock) {
                Swal.fire({
                    icon: "error",
                    title: "Stock Insuficiente",
                    text: "La cantidad total supera el stock disponible",
                });
                return; // No continuar si la cantidad total supera el stock
            }

            // Si no supera el stock, actualiza la cantidad y el subtotal en la lista
            existingProducto.cantidad += peso; // Suma el peso a la cantidad existente
            existingProducto.subtotal += peso * precioPorKG;

            // Actualiza la cantidad y el subtotal en la tabla
            var filaExistente = table.find('tr:eq(' + (indexProductoExistente + 1) + ')');
            filaExistente.find('td:eq(3)').text(existingProducto.cantidad.toFixed(3)); // Asegúrate de que se muestre con 3 decimales
            filaExistente.find('td:eq(5)').text('$' + existingProducto.subtotal.toFixed(2));
        } else {
            // Si el producto no existe, verifica si la cantidad a agregar supera el stock
            if (peso > stock) {
                Swal.fire({
                    icon: "error",
                    title: "Stock Insuficiente",
                    text: "El peso ingresado supera el stock disponible",
                });
                return; // No agregar a la tabla si el peso supera el stock
            }

            // Agrega una nueva fila a la tabla
            agregarFila(id_producto, nombre, descripcion, peso, precio_venta, peso * precioPorKG);
        }

        // Vaciar el campo de peso
        $('#peso').val('');

        // Cerrar el modal de KG
        $('#kgModal').modal('hide');

        // Vacía los campos después de agregar
        $('#ventas-id_producto').val('').trigger('change');
        $('#ventas-cantidad').val('');
        $('#ventas-precio_venta').val('');
        ajustarAlturaContenedor();
    } else {
        console.error('Error en la entrada de peso o precio por KG.');
    }
});







});
JS;

$this->registerJs($js);
