<?php

namespace backend\models;

use Yii;
use common\models\User; 

/**
 * This is the model class for table "ventas".
 *
 * @property int $id
 * @property string $fecha
 * @property int $user_id
 * @property int $id_cliente
 * @property int $id_estado
 * @property float $Total
 *
 * @property Clientes $cliente
 * @property Productos $producto
 * @property DetalleVentas[] $detalleVentas
 * @property Estadoventa $estado
 * @property User $user
 */
class Ventas extends \yii\db\ActiveRecord

{

    public $id_producto;
    public $total;

    public $adeudo;
    public $cantidad;
    public $precio_venta;
    public $productos_data;
    public $datosTabla; 
    public $datos_tabla_input;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ventas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'user_id', 'id_cliente', 'id_estado', 'Total'], 'required'],
            [['fecha'], 'safe'],
            [['user_id', 'id_cliente', 'id_estado'], 'integer'],
            [['Total'], 'number'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoventa::class, 'targetAttribute' => ['id_estado' => 'id']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::class, 'targetAttribute' => ['id_cliente' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'user_id' => 'User ID',
            'id_cliente' => 'Id Cliente',
            'id_estado' => 'Id Estado',
            'Total' => 'Total',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasOne(Clientes::class, ['id' => 'id_cliente']);
    }

    /**
     * Gets query for [[DetalleVentas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleVentas()
    {
        return $this->hasMany(DetalleVentas::class, ['id_ventas' => 'id']);
    }

    /**
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estadoventa::class, ['id' => 'id_estado']);
    }


    public function getEstados()
    {
        return $this->estado->estado_venta; 
    }
    
    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */


     public static function getClientesLista()
     {
         $clientes = Clientes::find()->asArray()->all();
         $clientesLista = [];
         
         foreach ($clientes as $cliente) {
             // Combina el nombre y el apellido en el formato "Nombre Apellido"
             $nombreApellido = $cliente['nombre'] . ' ' . $cliente['apellido'];
             $clientesLista[$cliente['id']] = $nombreApellido;
         }
         
         return $clientesLista;
     }

     public static function getProductosLista()
     {
         $productos = Productos::find()
             ->with('um') // cargar la relación um
             ->asArray()
             ->all();
     
         $productosLista = [];
     
         foreach ($productos as $producto) {
             // Obtener la Unidad en lugar del ID
             $unidad = isset($producto['um']['Unidad']) ? $producto['um']['Unidad'] : '';
     
             // Agregar tanto el ID, la descripción, la unidad, el precio de venta y el stock al arreglo
             $productosLista[$producto['id']] = $producto['nombre'] . ' - ' . $producto['descripcion'] .  ' - $' . $producto['precio_venta'] . ' - ' . $producto['stock'].' ' . $unidad ;
         }
     
         return $productosLista;
     }
     
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUsuario()
    {
        return $this->user->username;
    }

    public function getcliente()
    {
        return $this->clientes->nombre . ' ' . $this->clientes->apellido;
    }


    public function getAdeudo()
    {
        if ($this->cliente !== null) {
            return $this->clientes->Credito ;
        } 
    }


    public function getDeuda()
    {
        return $this->hasOne(Deuda::class, ['id' => 'id_venta']);
    }

}
