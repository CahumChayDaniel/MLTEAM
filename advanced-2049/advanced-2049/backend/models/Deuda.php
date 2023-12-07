<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "deuda".
 *
 * @property int $id
 * @property int $id_venta
 * @property float $monto_pendiente
 *
 * @property Pago[] $pagos
 * @property Ventas $venta
 */
class Deuda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deuda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_venta', 'monto_pendiente'], 'required'],
            [['id_venta'], 'integer'],
            [['monto_pendiente'], 'number'],
            [['id_venta'], 'exist', 'skipOnError' => true, 'targetClass' => Ventas::class, 'targetAttribute' => ['id_venta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_venta' => 'Id Venta',
            'monto_pendiente' => 'Monto Pendiente',
        ];
    }

    /**
     * Gets query for [[Pagos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagos()
    {
        return $this->hasMany(Pago::class, ['id_deuda' => 'id']);
    }

    /**
     * Gets query for [[Venta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenta()
    {
        return $this->hasOne(Ventas::class, ['id' => 'id_venta']);
    }
}
