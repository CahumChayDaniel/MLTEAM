<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DetalleVentas;

/**
 * DetalleVentasSearch represents the model behind the search form of `backend\models\DetalleVentas`.
 */
class DetalleVentasSearch extends DetalleVentas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_ventas', 'user_id', 'id_producto', 'cantidad'], 'integer'],
            [['fecha'], 'safe'],
            [['precio_venta', 'subtotal'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DetalleVentas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_ventas' => $this->id_ventas,
            'user_id' => $this->user_id,
            'fecha' => $this->fecha,
            'id_producto' => $this->id_producto,
            'cantidad' => $this->cantidad,
            'precio_venta' => $this->precio_venta,
            'subtotal' => $this->subtotal,
        ]);

        return $dataProvider;
    }
}
