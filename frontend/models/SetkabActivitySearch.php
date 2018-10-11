<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\SetkabActivity;

/**
 * SetkabActivitySearch represents the model behind the search form about `frontend\models\SetkabActivity`.
 */
class SetkabActivitySearch extends SetkabActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'assessee_id', 'assessor_id', 'second_opinion_id'], 'integer'],
            [['tanggal_test', 'tempat_test', 'tujuan_pemeriksaan'], 'safe'],
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
        $query = SetkabActivity::find();

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
            'assessee_id' => $this->assessee_id,
            'assessor_id' => $this->assessor_id,
            'second_opinion_id' => $this->second_opinion_id,
            'tanggal_test' => $this->tanggal_test,
        ]);

        $query->andFilterWhere(['like', 'tempat_test', $this->tempat_test])
            ->andFilterWhere(['like', 'tujuan_pemeriksaan', $this->tujuan_pemeriksaan]);

        return $dataProvider;
    }
}
