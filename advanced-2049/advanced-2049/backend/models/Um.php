<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "um".
 *
 * @property int $id
 * @property string $Unidad
 *
 * @property Productos[] $productos
 */
class Um extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'um';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Unidad'], 'required'],
            [['Unidad'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Unidad' => 'Unidad',
        ];
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['UM' => 'id']);
    }
}
