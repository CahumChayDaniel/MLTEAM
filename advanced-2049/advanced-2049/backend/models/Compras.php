<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User; 
use backend\models\Productos; 


/**
 * This is the model class for table "compras".
 *
 * @property int $id
 * @property string $fecha
 * @property int $user_id
 * @property int $id_proveedor
 * @property int $id_estado
 * @property float $adeudo
 * @property float $total
 *
 * @property DetalleCompras[] $detalleCompras
 * @property Estadoventa $estado
 * @property Proveedores $proveedor
 * @property User $user
 * @property User $productos
 */
class Compras extends \yii\db\ActiveRecord
{
    public $cantidad;
    public $id_producto;
    public $precio_costo;
    public $Total;
    public $efectivo;
    public $credito;
    public $productos_data;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'user_id', 'id_proveedor', 'id_estado', 'adeudo', 'total'], 'required'],
            [['fecha'], 'safe'],
            [['user_id', 'id_proveedor', 'id_estado'], 'integer'],
            [['adeudo', 'total'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['id_proveedor'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::class, 'targetAttribute' => ['id_proveedor' => 'id']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoventa::class, 'targetAttribute' => ['id_estado' => 'id']],

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
            'id_proveedor' => 'Id Proveedor',
            'id_estado' => 'Id Estado',
            'adeudo' => 'Adeudo',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[DetalleCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleCompras()
    {
        return $this->hasMany(DetalleCompras::class, ['id_compras' => 'id']);
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
        return $this->estado->estado_venta; // <-- Usa 'estado' en lugar de 'EstadoVenta'
    }
    

    /**
     * Gets query for [[Proveedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProveedores()
    {
        return $this->hasOne(Proveedores::class, ['id' => 'id_proveedor']);
    }

    public static function getProveedoresLista()
    {
        $proveedores = Proveedores::find()->asArray()->all();
    
        $proveedoresLista = ArrayHelper::map($proveedores, 'id', 'empresa');
    
        return $proveedoresLista;
    }


    public static function getProductosLista()
    {
        $productos = Productos::find()->asArray()->all();
        $productosLista = [];

        foreach ($productos as $producto) {
            // Agregar tanto el ID como la descripción y el precio de venta al arreglo
            $productosLista[$producto['id']] = $producto['nombre'].' - '. $producto['descripcion'] . ' - $' . $producto['precio_costo'];
        }

        return $productosLista;
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public function getUsuario()
    {
        return $this->user->username;
    }

        public function getProveedor()
    {
        return $this->proveedores->empresa;
    }
    public function getNombre()
    {
        if ($this->proveedores !== null) {
            return $this->proveedores->nombre . ' ' . $this->proveedores->apellido;
        } else {
            return 'Proveedor no encontrado';
        }
    }

   
}

    

    

