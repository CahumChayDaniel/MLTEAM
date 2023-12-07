<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "estadoventa".
 *
 * @property int $id
 * @property string $estado_venta
 *
 * @property Ventas[] $ventas
 */
class Estadoventa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoventa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_venta'], 'required'],
            [['estado_venta'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado_venta' => 'Estado Venta',
        ];
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Ventas::class, ['id_estado' => 'id']);
    }
}
