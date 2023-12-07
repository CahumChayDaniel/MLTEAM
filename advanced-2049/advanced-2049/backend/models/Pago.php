<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pago".
 *
 * @property int $id
 * @property int $id_venta
 * @property int $id_deuda
 * @property string $fecha
 * @property float $monto_pagado
 *
 * @property Deuda $deuda
 * @property Ventas $venta
 */
class Pago extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_venta', 'id_deuda', 'fecha', 'monto_pagado'], 'required'],
            [['id_venta', 'id_deuda'], 'integer'],
            [['fecha'], 'safe'],
            [['monto_pagado'], 'number'],
            [['id_venta'], 'exist', 'skipOnError' => true, 'targetClass' => Ventas::class, 'targetAttribute' => ['id_venta' => 'id']],
            [['id_deuda'], 'exist', 'skipOnError' => true, 'targetClass' => Deuda::class, 'targetAttribute' => ['id_deuda' => 'id']],
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
            'id_deuda' => 'Id Deuda',
            'fecha' => 'Fecha',
            'monto_pagado' => 'Monto Pagado',
        ];
    }

    /**
     * Gets query for [[Deuda]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeuda()
    {
        return $this->hasOne(Deuda::class, ['id' => 'id_deuda']);
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
