<!-- Vista parcial _ticket.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta</title>
    <!-- Agrega aquí tus estilos CSS para el ticket -->
    <style>
        /* Estilos CSS para el ticket */
    </style>
</head>
<body>
    <h1>Ticket de Venta</h1>
    
    <p>Detalles de la venta:</p>
    <p>Fecha: <?= Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy HH:mm:ss') ?></p>
    <!-- Agrega aquí más detalles de la venta -->

    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->productos as $producto): ?>
                <tr>
                    <td><?= $producto->nombre ?></td>
                    <td><?= $producto->cantidad ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($producto->precio_venta) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($producto->subtotal) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Total: <?= Yii::$app->formatter->asCurrency($model->Total) ?></p>
    
    <!-- Puedes agregar más detalles y estilos según tus necesidades -->

</body>
</html>