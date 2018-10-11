<?php

namespace app\modules\projects\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\projects\models\ProjectActivity;

/**
 * ProjectActivitySearch represents the model behind the search form about `app\modules\projects\models\ProjectActivity`.
 */
class ProjectActivitySearch extends ProjectActivity
{

        public $assessor;
            public $so;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id'], 'integer'],
  [['assessor', 'so'], 'safe'],
            [['name', 'status', 'created_at', 'modified_at'], 'safe'],
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


        $query = ProjectActivity::find();
       $query->joinWith('projectActivityMetas')
//->where(
    //    'project_activity.id = project_activity_meta.project_activity_id'
  //      )
//->select('*, project_activity_meta.key as assid')

        ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [ 'pageSize' => 100 ],
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
            'project_id' => $this->project_id,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'status', $this->status])
            //->andFilterWhere(['like', 'assessor', $this->assessor])
                        //->andFilterWhere(['like', 'project_activity_meta.key', $this->assessor])
            ;


     $dataProvider->setSort([
        'attributes' => [
  /*          'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
                'label' => 'id',
                'default' => SORT_ASC
            ],
            'name' => [
                'asc' => ['name' => SORT_ASC],
                'desc' => ['name' => SORT_DESC],
                'label' => 'name',
                'default' => SORT_ASC
            ],
*/    
/*        'assessor' => [
                'asc' => ['project_activity_meta.key' => SORT_ASC],
                'desc' => ['project_activity_meta.key' => SORT_DESC],
                'label' => 'assessor',
                'default' => SORT_ASC
            ],
*/
        ],
        /*'defaultOrder' => [
            'assessor' => SORT_ASC
        ]
        */
    ]);


        return $dataProvider;
    }
}
