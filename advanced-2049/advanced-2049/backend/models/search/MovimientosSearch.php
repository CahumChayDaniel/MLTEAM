<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Movimientos;

/**
 * MovimientosSearch represents the model behind the search form of `backend\models\Movimientos`.
 */
class MovimientosSearch extends Movimientos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_tipo', 'user_id'], 'integer'],
            [['motivo', 'fecha'], 'safe'],
            [['monto'], 'number'],
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
        $query = Movimientos::find();

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
            'id_tipo' => $this->id_tipo,
            'monto' => $this->monto,
            'user_id' => $this->user_id,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'motivo', $this->motivo]);

        return $dataProvider;
    }
}
