<?php

namespace backend\controllers;

use frontend\models\Perfil;
use backend\models\search\PerfilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\RegistrosHelpers;  // Añade esta línea al principio del archivo, junto con otras declaraciones use


use common\models\PermisosHelpers;

use yii;

/**
 * PerfilController implements the CRUD actions for Perfil model.
 */
class PerfilController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::className(),
                    'only' => ['index', 'view','create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'view',],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                             return PermisosHelpers::requerirMinimoRol('Admin') 
                             && PermisosHelpers::requerirEstado('Activo');
                            }
                        ],
                         [
                            'actions' => [ 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                             return PermisosHelpers::requerirMinimoRol('Admin') 
                             && PermisosHelpers::requerirEstado('Activo');
                            }
                        ],
                             
                    ],
                         
                ],

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
     * Lists all Perfil models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PerfilSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Perfil model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $ya_existe = RegistrosHelpers::userTiene('perfil');
    
        if ($ya_existe) {
            $perfilModel = \frontend\models\Perfil::findOne(['user_id' => Yii::$app->user->id]);
    
            if ($perfilModel !== null) {
                return $this->render('view', [
                    'model' => $perfilModel,
                ]);
            }
        }
    
        // Si no existe, redirige a la acción create
        return $this->redirect(['create']);
    }
    /**
     * Creates a new Perfil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Perfil;        
        $model->user_id = \Yii::$app->user->identity->id;
        if ($ya_existe = RegistrosHelpers::userTiene('perfil')) {
            return $this->render('view', [
                   'model' => $this->findModel($ya_existe),
                ]);
        } elseif ($model->load(Yii::$app->request->post()) && $model->save()){
                            
            return $this->redirect(['view']);
                            
        } else {
                    
            return $this->render('create', [

                    'model' => $model,

                    ]);
        }
    }

    /**
     * Updates an existing Perfil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
{
    PermisosHelpers::requerirUpgradeA('Pago');  

    $model = Perfil::findOne(['user_id' => Yii::$app->user->identity->id]);

    if ($model !== null) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view']);
        } else {
            return $this->render('update', ['model' => $model]);
        }
    } else {
        throw new NotFoundHttpException('No existe el perfil.');
    }
}


    /**
     * Deletes an existing Perfil model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
            
        $model =  Perfil::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                
        $this->findModel($model->id)->delete();
            
        return $this->redirect(['site/index']);
    }


    /**
     * Finds the Perfil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Perfil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perfil::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
