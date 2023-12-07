<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "proveedores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property string $empresa
 * @property int $telefono
 */
class Proveedores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proveedores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'empresa', 'telefono'], 'required'],
            [['telefono'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
            [['apellido'], 'string', 'max' => 30],
            [['empresa'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'empresa' => 'Empresa',
            'telefono' => 'Telefono',
        ];
    }
}
