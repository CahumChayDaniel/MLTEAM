<?php

namespace backend\models;


use Yii;
use common\models\User; 

/**
 * This is the model class for table "detalle_ventas".
 *
 * @property int $id
 * @property int $id_ventas
 * @property int $user_id
 * @property string $fecha
 * @property int $id_producto
 * @property int $cantidad
 * @property float $precio_venta
 * @property float $subtotal
 *
 * @property Productos $producto
 * @property User $user
 * @property Ventas $ventas
 */
class DetalleVentas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_ventas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ventas', 'user_id', 'fecha', 'id_producto', 'cantidad', 'precio_venta', 'subtotal'], 'required'],
            [['id_ventas', 'user_id', 'id_producto', 'cantidad'], 'integer'],
            [['fecha'], 'safe'],
            [['precio_venta', 'subtotal'], 'number'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::class, 'targetAttribute' => ['id_producto' => 'id']],
            [['id_ventas'], 'exist', 'skipOnError' => true, 'targetClass' => Ventas::class, 'targetAttribute' => ['id_ventas' => 'id']],
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
            'id_ventas' => 'Id Ventas',
            'user_id' => 'User ID',
            'fecha' => 'Fecha',
            'id_producto' => 'Id Producto',
            'cantidad' => 'Cantidad',
            'precio_venta' => 'Precio Venta',
            'subtotal' => 'Subtotal',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::class, ['id' => 'id_producto']);
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

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasOne(Ventas::class, ['id' => 'id_ventas']);
    }
}
