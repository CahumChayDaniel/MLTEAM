<?php

namespace backend\controllers;

use backend\models\Deuda;
use backend\models\Pago;
use backend\models\search\DeudaSearch;
use backend\models\Ventas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\base\Yii;


/**
 * DeudaController implements the CRUD actions for Deuda model.
 */
class DeudaController extends Controller
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
     * Lists all Deuda models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DeudaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deuda model.
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
     * Creates a new Deuda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Deuda();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Deuda model.
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
     * Deletes an existing Deuda model.
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


    public function actionGuardarAbono()
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $idVenta = \Yii::$app->request->post('idVenta');
            $montoAbono = \Yii::$app->request->post('montoAbono');

            $deudaModel = Deuda::findOne(['id_venta' => $idVenta]);

            if ($deudaModel) {
                $deudaModel->monto_pendiente -= $montoAbono;

                if ($deudaModel->save()) {

                    $montoPendienteDespues = $deudaModel->monto_pendiente;
                    if ($montoPendienteDespues == 0) {
                        // Si el monto_pendiente es 0, actualizar el estado en Ventas
                        $ventaModel = Ventas::findOne($idVenta);
                        if ($ventaModel) {
                            $ventaModel->id_estado = 1; // Asigna el nuevo estado
                            $ventaModel->save();
                        }

                        // Guardar un nuevo dato en el modelo Pago
                        $pagoModel = new Pago();
                        $pagoModel->id_venta = $idVenta;
                        $pagoModel->id_deuda = $deudaModel->id; 
                        $pagoModel->fecha = date('Y-m-d H:i:s'); // Fecha actual
                        $pagoModel->monto_pagado = $montoAbono;
                        $pagoModel->save();

                    }


                    return ['success' => true, 'message' => 'Abono guardado correctamente'];
                } else {
                    return ['success' => false, 'message' => 'Error al guardar el abono: ' . implode(', ', $deudaModel->errors)];
                }
            } else {
                return ['success' => false, 'message' => 'No se encontró la deuda asociada a la venta'];
            }
        }



        public function actionSaldarDeudaTotal()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $idCliente = \Yii::$app->request->post('idCliente'); // Ajusta según tu lógica

    // Obtén todas las ventas asociadas al cliente
    $ventasCliente = Ventas::find()->where(['id_cliente' => $idCliente])->all();

    // Itera sobre todas las ventas y realiza el proceso de abono para cada una
    foreach ($ventasCliente as $venta) {
        $deudaModel = Deuda::findOne(['id_venta' => $venta->id]);

        if ($deudaModel) {
            // Verifica si la deuda ya está saldada
            if ($deudaModel->monto_pendiente > 0) {
                // Almacena el monto total de la deuda antes de establecerlo en cero
                $montoAbono = $deudaModel->monto_pendiente;

                // Resta el monto pendiente actual
                $deudaModel->monto_pendiente = 0;

                if ($deudaModel->save()) {
                    $ventaModel = Ventas::findOne($venta->id);
                    if ($ventaModel) {
                        $ventaModel->id_estado = 1; // Asigna el nuevo estado
                        $ventaModel->save();
                    }

                    // Guardar un nuevo dato en el modelo Pago
                    $pagoModel = new Pago();
                    $pagoModel->id_venta = $venta->id;
                    $pagoModel->id_deuda = $deudaModel->id; 
                    $pagoModel->fecha = date('Y-m-d H:i:s'); // Fecha actual
                    $pagoModel->monto_pagado = $montoAbono; // Guarda el monto total pagado
                    $pagoModel->save(); 
                } else {
                    return ['success' => false, 'message' => 'Error al saldar la deuda: ' . implode(', ', $deudaModel->errors)];
                }
            }
        }
    }

    return ['success' => true, 'message' => 'Deuda total saldada correctamente'];
}
    /**
     * Finds the Deuda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Deuda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Deuda::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
