<?php

namespace backend\controllers;

use backend\models\Compras;
use backend\models\Productos;

use backend\models\DetalleCompras;
use backend\models\search\ComprasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * ComprasController implements the CRUD actions for Compras model.
 */
class ComprasController extends Controller
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
     * Lists all Compras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComprasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compras model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Obtener el modelo Compras
        $model = $this->findModel($id);
    
        // Mostrar los mensajes de flash si los hay
        $successMessage = Yii::$app->session->getFlash('success');
        $errorMessage = Yii::$app->session->getFlash('error');
    
        return $this->render('view', [
            'model' => $model,
            'successMessage' => $successMessage,
            'errorMessage' => $errorMessage,

        ]);
    }
    /**
     * Creates a new Compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    
     public function actionCreate()
     {
         $model = new Compras();

         if ($this->request->isPost) {
            var_dump($_POST);

             // Guardar los datos de la compra
             $compraData = Yii::$app->request->post('Compras');
             $model->load($compraData, '');
     
             // Guardar la compra en la base de datos
             if ($model->save()) {
                 // Obtener la cadena JSON de productos_data desde el formulario
                 $productosData = Yii::$app->request->post('Compras')['productos_data'];
     
                 // Decodificar la cadena JSON a un array asociativo
                 $productosData = json_decode($productosData, true);
     
                 // Guardar los detalles de los productos asociados a la compra
                 foreach ($productosData as $producto) {
                     $detalleCompras = new DetalleCompras();
     
                     // Asignar los atributos del producto al modelo de detalle
                     $detalleCompras->id_compras = $model->id;
                     $detalleCompras->user_id = $model->user_id;
                     $detalleCompras->fecha = $model->fecha;
                     $detalleCompras->id_producto = $producto['id_producto'];
                     $detalleCompras->cantidad = $producto['cantidad'];
                     $detalleCompras->precio_compra = $producto['precio_compra'];
                     $detalleCompras->subtotal = $producto['subtotal'];

                      // Obtener el modelo de producto correspondiente
                        $productoModel = Productos::findOne($detalleCompras->id_producto);

                        // Verificar si se encontró el modelo de producto
                        if ($productoModel) {
                            // Sumar la cantidad comprada al valor actual en stock
                            $productoModel->stock += $detalleCompras->cantidad;

                            // Guardar la actualización del stock en la base de datos
                            $productoModel->save();
                        }
     
                     // Guardar el detalle del producto en la base de datos
                     $detalleCompras->save();
                 }
                 Yii::$app->session->setFlash('success', 'La compra se ha realizado con éxito.');

     
             } else {
                Yii::$app->session->setFlash('error', 'Error al guardar la compra. Por favor, inténtelo de nuevo.');

             }
         } else {
             $model->loadDefaultValues();
         }
     
         return $this->render('create', [
             'model' => $model,
         ]);
     }


     public function actionAdeudocompra()
     {
         $montoAbono = Yii::$app->request->post('montoAbono');
         $compraId = Yii::$app->request->post('compraId');
     
         $compra = Compras::findOne($compraId);
         if ($compra) {
             // Actualiza el adeudo
             $compra->adeudo -= $montoAbono;
             $compra->save();
     
             // Puedes devolver una respuesta si es necesario
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ['success' => true];
         } else {
             // Puedes devolver un error si la compra no se encuentra
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ['success' => false, 'error' => 'Compra no encontrada'];
         }
     }

    /**
     * Updates an existing Compras model.
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
     * Deletes an existing Compras model.
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
     * Finds the Compras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Compras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compras::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
