<?php

namespace backend\controllers;



use backend\models\Clientes;
use backend\models\DetalleVentas;
use backend\models\Deuda;
use backend\models\Pago;
use backend\models\Ventas;
use backend\models\search\VentasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Productos;
use yii\helpers\VarDumper;


use Yii;
/**
 * VentasController implements the CRUD actions for Ventas model.
 */

class VentasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Ventas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VentasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ventas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ventas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
 
     public function actionCreate()
     {
         $model = new Ventas();
         $deuda = new Deuda();
         $pago= new Pago();
     
         $transaction = Yii::$app->db->beginTransaction();
     
         try {
             if ($this->request->isPost) {
                
                 // Guardar los datos de la venta
                 $ventaData = Yii::$app->request->post('Ventas');
                 $model->load($ventaData, '');

                 $adeudo = Yii::$app->request->post('Ventas')['adeudo'];

                 // Guardar la venta en la base de datos
                 if ($model->save()) {

                    $deuda->id_venta = $model->id;
                    $deuda->monto_pendiente = $adeudo;
                    $deuda->save();

                    $pago->id_venta = $model->id;
                    $pago->id_deuda = $deuda->id;
                    $pago->fecha= $model->fecha;

                    $pago->monto_pagado = $model->Total - $adeudo;

                    $pago->save();

                     // Obtener la cadena JSON de productos_data desde el formulario
                     $productosData = Yii::$app->request->post('Ventas')['productos_data'];
     
                     // Decodificar la cadena JSON a un array asociativo
                     $productosData = json_decode($productosData, true);
     
                     // Guardar los detalles de los productos asociados a la venta
                     foreach ($productosData as $producto) {
                         $detalleVentas = new DetalleVentas();
     
                         // Asignar los atributos del producto al modelo de detalle
                         $detalleVentas->id_ventas = $model->id;
                         $detalleVentas->user_id = $model->user_id;
                         $detalleVentas->fecha = $model->fecha;
                         $detalleVentas->id_producto = $producto['id_producto'];
                         $detalleVentas->cantidad = $producto['cantidad'];
                         $detalleVentas->precio_venta = $producto['precio_compra'];
                         $detalleVentas->subtotal = $producto['subtotal'];
     
                         // Obtener el modelo de producto correspondiente
                         $productoModel = Productos::findOne($detalleVentas->id_producto);
     
                         // Verificar si se encontró el modelo de producto
                         if ($productoModel) {
                             // Restar la cantidad vendida al valor actual en stock
                             $productoModel->stock -= $detalleVentas->cantidad;
     
                             // Guardar la actualización del stock en la base de datos
                             $productoModel->save();
                         }

                         // Guardar el detalle del producto en la base de datos
                         $detalleVentas->save();
                     }
     
                     // Confirmar la transacción si todo ha sido exitoso
                     $transaction->commit();
     
                     Yii::$app->session->setFlash('success', '');
                    } else {
                        Yii::$app->session->setFlash('error', '');
                    }
             } else {
                 $model->loadDefaultValues();
             }
         } catch (\Exception $e) {
             // En caso de cualquier excepción, revertir la transacción
             $transaction->rollBack();
             Yii::$app->session->setFlash('error', 'Error al procesar la venta. Por favor, inténtelo de nuevo.');
     
             // Puedes registrar el error si lo deseas
             Yii::error('Error en la transacción: ' . $e->getMessage());
         }
     
         return $this->render('create', [
             'model' => $model,
         ]);
     }

    /**
     * Updates an existing Ventas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    /**
     * Deletes an existing Ventas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionGenerarTicket($ventaId)
    {
        // Lógica para obtener los datos de la venta y generar el ticket
        $model = Ventas::findOne($ventaId);

        if ($model !== null) {
            $content = $this->renderPartial('_ticket', ['model' => $model]);

            // Guardar el ticket en un archivo temporal
            $tempFilePath = Yii::getAlias('@runtime/tickets/') . 'ticket_' . $ventaId . '.pdf';
            file_put_contents($tempFilePath, $content);

            // Devolver el archivo temporal para su descarga
            return Yii::$app->response->sendFile($tempFilePath, 'ticket.pdf')->deleteFileAfterSend(true);
        } else {
            // Manejar el caso en que no se encuentre la venta
            throw new NotFoundHttpException('La venta no fue encontrada.');
        }
    }



    /**
     * Finds the Ventas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ventas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ventas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
