<?php

namespace backend\models;

use Yii;
use common\models\User; 

/**
 * This is the model class for table "detalle_compras".
 *
 * @property int $id
 * @property int $id_compras
 * @property int $user_id
 * @property string $fecha
 * @property int $id_producto
 * @property int $cantidad
 * @property float $precio_compra
 * @property float $subtotal
 *
 * @property Compras $compras
 * @property Productos $producto
 * @property User $user
 */
class DetalleCompras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_compras', 'user_id', 'fecha', 'id_producto', 'cantidad', 'precio_compra', 'subtotal'], 'required'],
            [['id_compras', 'user_id', 'id_producto', 'cantidad'], 'integer'],
            [['fecha'], 'safe'],
            [['precio_compra', 'subtotal'], 'number'],
            [['id_compras'], 'exist', 'skipOnError' => true, 'targetClass' => Compras::class, 'targetAttribute' => ['id_compras' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::class, 'targetAttribute' => ['id_producto' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_compras' => 'Id Compras',
            'user_id' => 'User ID',
            'fecha' => 'Fecha',
            'id_producto' => 'Id Producto',
            'cantidad' => 'Cantidad',
            'precio_compra' => 'Precio Compra',
            'subtotal' => 'Subtotal',
        ];
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasOne(Compras::class, ['id' => 'id_compras']);
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
}
