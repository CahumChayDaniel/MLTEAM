<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use  yii\jui\DatePicker;
use kartik\select2\Select2;


/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/ventas.css');

?>

<div class="compras-form">
    <!-- INICIO DEL FORMULARIO PARA MODELO COMPRAS -------------------->

<?php $form1 = ActiveForm::begin(['id' => 'form1']); ?>

<div class="form-field">
    <?php
    $fechaFormateada = $model->fecha ? Yii::$app->formatter->asDate($model->fecha, 'yyyy-MM-dd') : date('Y-m-d');
    ?>
    <?= $form1->field($model, 'fecha')->label('Fecha de Nacimiento')->textInput(['value' => $fechaFormateada, 'readonly' => true])->hiddenInput(['value' => $fechaFormateada])->label(false) ?>
</div>


    <?= $form1->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

    
    <?= $form1->field($model, 'id_proveedor', [
            'options' => ['id' => 'buscar'],
        ]
    )->widget(Select2::class, [
            'data' => $model->ProveedoresLista, // Utiliza la función definida en el modelo Clientes.
            'options' => ['placeholder' => 'Seleccione el proveedor'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>



    <?= $form1->field($model, 'total')->textInput(['maxlength' => true,'id' => 'total-input','style' => 'display: none;']) ->label(false)?>
   
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

                            <?= $form1->field($model, 'id_estado')->hiddenInput(['id' => 'ventas-id_estado'])->label(false) ?>

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


    <?php ActiveForm::end(); ?>
    <!------------------------------------------------------------------------------->

    <!-- INICIO DEL FORMULARIO PARA MODELO DETALLE_COMPRAS-->

    <?php $form2 = ActiveForm::begin(['id' => 'form2']); ?>

    <?= $form2->field($model, 'id_producto',
    [
        'options' => ['id' => 'buscar'],
    ])->widget(Select2::class, [
        'data' => $model->ProductosLista,
        'options' => ['placeholder' => 'Seleccione el producto'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'pluginEvents' => [
             //extrae y establece el precio costo en el input invisible de precio_costo
            'change' => 'function() {
                var selectedProduct = $(this).val();
                var productData = ' . json_encode($model->ProductosLista) . ';
                var precioCostoField = $("#' . Html::getInputId($model, 'precio_costo') . '");
               
                if (selectedProduct in productData) {
                    var datos = productData[selectedProduct].split(" - ");
                    var nombre = datos[0];
                    var precio = datos[2].replace("$", "").trim();
                    precioCostoField.val(precio);
                } else {
                    precioCostoField.val("");
                }
            }',
        ],
    ]) ?>

    <?= $form1->field($model, 'cantidad', ['options' => ['id' => 'cantidad']])
                ->textInput(['type' => 'number']) ?>
    
    <?= Html::button('', ['class' => 'bx bxs-cart-add menu-icon1', 'id' => 'agregar-producto']) ?>
              

    <?= $form2->field($model, 'precio_costo')->hiddenInput()->label(false) ?>



    <div id="tablaproductos">
    <table class="table" id="productos">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Precio Costo</th>
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
                <strong></strong> <span id="Total">0.00</span>
            </div>

            <?= Html::button('Cobrar', [
                'class' => 'cobrar-btn',
                'id' => 'cobrar-btn',
                'data-toggle' => 'modal',
                'data-target' => '#cobrar-modal'
            ]) ?>
            
         </div>
    <?php ActiveForm::end(); ?>

    
</div>

<?php


$script = <<< JS
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

   // Código para realizar acciones al hacer clic en el botón "Realizar Cobro"
   $('#realizar-cobro').on('click', function() {
       // Puedes realizar acciones aquí, por ejemplo, enviar datos al servidor
       var montoPago = $('#monto-pago').val();
       console.log('Monto a pagar:', montoPago);


       // Cierra el modal después de realizar el cobro
       $('#cobrar-modal').modal('hide');
   });

   // Función para actualizar el total en el modal y el adeudo
   function actualizarTotalEnModal() {
    var montoPago = parseFloat($('#monto-pago').val()) || 0;
    var totalModal = parseFloat($('#totalmodal').text().replace('$', '')) || 0;

    // Asegura que el monto-pago no sea menor que 0
    montoPago = Math.max(0, montoPago);

    // Asegura que el monto-pago no sea mayor que el total
    montoPago = Math.min(totalModal, montoPago);

    // Actualiza el valor de adeudo
    var adeudo = totalModal - montoPago;
    $('#adeudo').val(adeudo.toFixed(2));

    // Actualiza el valor de monto-pago en el campo
    $('#monto-pago').val(montoPago.toFixed(2));// Eliminado el .toFixed(2)


    if (adeudo>0) {
        // Actualiza el campo de cambio
       actualizarCambio2();
       idtotal();
    }if (montoEfectivo == montoPago ) {
        var cambio =0 ;

        $('#cambio').text('$' + cambio.toFixed(2));
        idtotal();

    } 
    
    else{
        // Actualiza el campo de cambio
         actualizarCambio();
         idtotal();
    }
    


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

function actualizarCambio2() {
  
  var montoEfectivo = parseFloat($('#monto-efectivo').val()) || 0;
  var montoPago= parseFloat($('#monto-pago').val()) || 0;

  var cambio = montoEfectivo - montoPago;
  $('#cambio').text('$' + cambio.toFixed(2));
}




    //ENVIAR FORMULARIOS AL CONTROLADOR---------------------------------------------

   $('#submit-form1').on('click', function() {

    // Recopila los datos de la tabla
    var productosData = [];
    $('#productos tbody tr').each(function() {
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
});
        //-------------------------------------------------------------------

    //CODIGO PARA PRODUCTOS EN LA TABLA TEMPORAL---------------------------------------------

    $(document).ready(function() {
    var selectedProducts = [];
    var table = $('#productos');
    var totalElement = $('#Total'); // Asegúrate de tener un elemento con el ID 'total' en tu formulario
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
    function agregarFila(id_producto, nombre, descripcion, cantidad, precio_costo, subtotal) {
        var precioCostoConSigno = '$' + precio_costo.toFixed(2);
        var subtotalConSigno = '$' + subtotal.toFixed(2);

        selectedProducts.push({ id_producto: id_producto, nombre: nombre, cantidad: cantidad, precio_costo: precio_costo, subtotal: subtotal });

        var newRow = '<tr><td>' + id_producto + '</td><td>' + nombre + '</td><td>' + descripcion + '</td><td>' + cantidad + '</td><td>' + precioCostoConSigno + '</td><td>' + subtotalConSigno + '</td><td><button class="eliminar-producto ">Eliminar</button></td></tr>';

        table.append(newRow);
        actualizarTotal();
    }

    // Agregar producto a la tabla
    $('#agregar-producto').click(function() {
        var id_producto = $('#compras-id_producto').val(); // Ajusta el ID del campo de producto según tu formulario
        var nombre = $('#compras-id_producto option:selected').text().split(' - ')[0]; // Ajusta el ID del campo de producto según tu formulario
        var descripcion = $('#compras-id_producto option:selected').text().split(' - ')[1]; // Ajusta el ID del campo de producto según tu formulario
        var cantidad = parseInt($('#compras-cantidad').val(), 10); // Ajusta el ID del campo de cantidad según tu formulario
        var precio_costo = parseFloat($('#compras-precio_costo').val()); // Ajusta el ID del campo de precio_costo según tu formulario

        if (id_producto && !isNaN(cantidad) && !isNaN(precio_costo) && cantidad > 0) {
            if (cantidad < 1) {
                alert('La cantidad no puede ser menor a 1.');
                return;
            }

            var indexProductoExistente = buscarProductoPorId(id_producto);

            if (indexProductoExistente !== -1) {
                // Si el producto ya existe, actualiza la cantidad y el subtotal en la lista
                var existingProducto = selectedProducts[indexProductoExistente];
                existingProducto.cantidad += cantidad;
                var precioCosto = existingProducto.precio_costo;
                existingProducto.subtotal = existingProducto.cantidad * precioCosto;

                // Actualiza la cantidad y el subtotal en la tabla
                var filaExistente = table.find('tr:eq(' + (indexProductoExistente + 1) + ')');
                filaExistente.find('td:eq(3)').text(existingProducto.cantidad);
                filaExistente.find('td:eq(5)').text('$' + existingProducto.subtotal.toFixed(2));
            } else {
                // Si el producto no existe, agrega una nueva fila a la tabla
                var subtotal = cantidad * precio_costo;
                agregarFila(id_producto, nombre, descripcion, cantidad, precio_costo, subtotal);
            }

            // Vacía los campos después de agregar
            $('#compras-id_producto').val('').trigger('change'); // Ajusta el ID del campo de producto según tu formulario
            $('#compras-cantidad').val(''); // Ajusta el ID del campo de cantidad según tu formulario
            $('#compras-precio_costo').val(''); // Ajusta el ID del campo de precio_costo según tu formulario

            // Actualiza los campos del formulario con el nuevo total
            actualizarTotal();
            ajustarAlturaContenedor()
        } else {
            alert('Por favor, ingrese valores válidos para cantidad y precio de costo.');
        }
    });

    // Manejar el evento de eliminación de productos
    table.on('click', '.eliminar-producto', function() {
        var rowIndex = $(this).closest('tr').index();
        selectedProducts.splice(rowIndex, 1);
        $(this).closest('tr').remove();
        actualizarTotal();
    });

     // -----------------------------------------------------------


    // JS PARA AGREGAR EL TOTAL SIN SIGNOS A UN INPUT PARA ENVIAR --------------------

    // Obtén el valor inicial del span y elimina el símbolo de peso
             var totalSpan = $('#Total');
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


        function ajustarAlturaContenedor() {
            var tabla = document.getElementById("productos");
            var contenedor = document.getElementById("tablaproductos");
            
            // Ajusta la altura del contenedor según la altura de la tabla con un incremento de 10 píxeles
            contenedor.style.height = (tabla.scrollHeight + 30) + "px";
        }

});

JS;

$this->registerJs($script);
?>
