<?php

namespace backend\controllers;

use backend\models\Clientes;
use backend\models\search\ClientesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use backend\models\Ventas;



/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
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
     * Lists all Clientes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
      
        $deudaTotal = (new \yii\db\Query())
        ->from('deuda')
        ->join('INNER JOIN', 'ventas', 'deuda.id_venta = ventas.id')
        ->where(['ventas.id_cliente' => $model->id])
        ->sum('monto_pendiente');

        $ventasCliente = (new \yii\db\Query())
        ->select([
            'ventas.*',
            'deuda.monto_pendiente',
        ])
        ->from('ventas')
        ->leftJoin('deuda', 'deuda.id_venta = ventas.id')
        ->where(['ventas.id_cliente' => $model->id])
        ->andWhere(['>', 'deuda.monto_pendiente', 0]) // Filtra solo deudas mayores a 0
        ->all();


        $detallesVentas = [];
        foreach ($ventasCliente as $venta) {
            $detalles = (new \yii\db\Query())
                ->select(['dv.id_producto', 'p.nombre', 'p.descripcion', 'dv.cantidad','dv.subtotal'])
                ->from(['dv' => 'detalle_ventas'])
                ->join('INNER JOIN', 'productos p', 'dv.id_producto = p.id')
                ->where(['dv.id_ventas' => $venta['id']])
                ->all();
        
            $detallesVentas[$venta['id']] = $detalles;
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'deudaTotal' => $deudaTotal,
            'ventasCliente' => $ventasCliente, // Pasar las ventas asociadas al cliente a la vista
            'detallesVentas' => $detallesVentas,

        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Clientes();
    
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
    
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clientes model.
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
     * Deletes an existing Clientes model.
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

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
