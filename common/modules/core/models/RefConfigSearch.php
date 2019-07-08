<?php

namespace common\modules\core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\core\models\RefConfig;

/**
 * RefConfigSearch represents the model behind the search form about `frontend\models\RefConfig`.
 */
class RefConfigSearch extends RefConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'key', 'value'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = RefConfig::find();

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
        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
