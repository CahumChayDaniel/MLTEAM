<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $UM
 * @property int $id_categoria
 * @property int $stock
 * @property float $precio_costo
 * @property float $precio_venta
 *
 * @property Categoria $categoria
 * @property DetalleCompras[] $detalleCompras
 * @property DetalleVentas[] $detalleVentas
 * @property Um $uM
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'UM', 'id_categoria', 'stock', 'precio_costo', 'precio_venta'], 'required'],
            [['UM', 'id_categoria', 'stock'], 'integer'],
            [['precio_costo', 'precio_venta'], 'number'],
            [['nombre', 'descripcion'], 'string', 'max' => 50],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['id_categoria' => 'id']],
            [['UM'], 'exist', 'skipOnError' => true, 'targetClass' => Um::class, 'targetAttribute' => ['UM' => 'id']],
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
            'descripcion' => 'Descripcion',
            'UM' => 'Um',
            'id_categoria' => 'Id Categoria',
            'stock' => 'Stock',
            'precio_costo' => 'Precio Costo',
            'precio_venta' => 'Precio Venta',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasOne(Categoria::class, ['id' => 'id_categoria']);
    }

    public static function getCategoriaLista()
    {
        $dropciones = Categoria::find()->asArray()->all();
        return ArrayHelper::map($dropciones, 'id', 'categoria_nombre');
    }


    /**
     * Gets query for [[DetalleCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleCompras()
    {
        return $this->hasMany(DetalleCompras::class, ['id_producto' => 'id']);
    }

    /**
     * Gets query for [[DetalleVentas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleVentas()
    {
        return $this->hasMany(DetalleVentas::class, ['id_producto' => 'id']);
    }

    public function getCategoria()
    {
        return $this->categorias->categoria_nombre;
    }

    /**
     * Gets query for [[UM]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUm()
    {
        return $this->hasOne(Um::class, ['id' => 'UM']);
    }
    public function getUmLista()
    {
        $dropciones = Um::find()->asArray()->all();
        return ArrayHelper::map($dropciones, 'id', 'Unidad');    }
    public function getUnidad()
    {
         return $this->um->Unidad;
    }

    }
