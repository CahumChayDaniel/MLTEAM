<?php

namespace backend\models;

use Yii;
use common\models\User; 

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "movimientos".
 *
 * @property int $id
 * @property int $id_tipo
 * @property string $motivo
 * @property float $monto
 * @property int $user_id
 * @property string $fecha
 *
 * @property TipoMovimiento $tipo
 * @property User $user
 */
class Movimientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo', 'motivo', 'monto', 'user_id', 'fecha'], 'required'],
            [['id_tipo', 'user_id'], 'integer'],
            [['motivo'], 'string'],
            [['monto'], 'number'],
            [['fecha'], 'safe'],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoMovimiento::class, 'targetAttribute' => ['id_tipo' => 'id']],
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
            'id_tipo' => 'Id Tipo',
            'motivo' => 'Motivo',
            'monto' => 'Monto',
            'user_id' => 'User ID',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * Gets query for [[Tipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoMovimiento::class, ['id' => 'id_tipo']);
    }

    public function getTipo_Movimiento()
    {
        return $this->tipo->nombre;
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

    public static function getMovimientosLista()
    {
        $dropciones = TipoMovimiento::find()->asArray()->all();
        return ArrayHelper::map($dropciones, 'id', 'nombre');
    }

}
