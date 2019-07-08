<?php

namespace common\modules\assessment\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\modules\assessment\models\Assessment;
use common\modules\assessment\models\Result;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\profile\models\ProfileExtended;

/**
 * AssessmentSearch represents the model behind the search form about `app\modules\assessment\models\Assessment`.
 */
class TakerSearch extends Assessment
{

    public $catalog_id = '';
    public $location ='';
        public $score= '99';
        public $value;
        public $resultsum;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'value','catalog_id'], 'integer'],
                        [['location'], 'string'],
            [['id', 'location', 'value','catalog_id','resultsum'], 'safe'],
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
        $query = Assessment::find();

 //$query->select('*, (id * id) as score');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
  //  'sort'=> ['defaultOrder' => ['resultsum'=>SORT_ASC]],
        ]);


        $subquery = Result::find()->select('assessment_id, SUM(value) as order_sum')
        ->andWhere(['attribute_1' => 'correct'])
        ->addGroupby('assessment_id');
        
        $subquery2 = Assessment::find()->select('MAX(assessment.id) as id, catalog_id, user_id,status,result_uri,result,timestamp')
                ->andWhere(['assessment.status' => 'finished'])
->addGroupby('assessment.user_id')
->addGroupby('assessment.catalog_id')
                //->addOrderby('assessment.id DESC')
                ;



    $dataProvider->setSort([
        'attributes' => [
        'resultsum' => [
                'asc' => ['scoresum.order_sum' => SORT_ASC],
                'desc' => ['scoresum.order_sum' => SORT_DESC],
                'default' => SORT_ASC,
                ],
                //'id',
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        //'asc' => ['tbl_city.name' => SORT_ASC],
        //'desc' => ['tbl_city.name' => SORT_DESC],
    ],
       'defaultOrder' => ['resultsum' => SORT_DESC]
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
          //  'location' => $this->location,
            //'score' => $this->score,
        ]);

                $query
                ->from(['assessment2' => $subquery2])
                ->andWhere(['assessment2.catalog_id' => $this->catalog_id])
        //->orderBy('assessment.user_id DESC, assessment.id DESC')
        //->groupBy('assessment.user_id')
                             //->select('assessment.id, assessment.user_id, assessment.catalog_id, assessment.status as status, result.type, sum(result.value) as score')
                             //->select('assessment.*, sum(o.value) as sumofscore')
//                      ->leftJoin(['ass2' => $subquery2],'ass2.id = id')
                     ->leftJoin(['scoresum' => $subquery],'scoresum.assessment_id = id')
                     //
                             // ->joinWith(['sum']);
                             /*->joinWith(['results o'])
                                ->where('o.assessment_id = assessment.id')
                                */

        ;


        $location_array =  ArrayHelper::getColumn(ProfileExtended::find()->andWhere(['type' => 'edulab'])->andWhere(['key'=>'location'])->andWhere(['value' => $this->location])->asArray()->All(),'user_id');
        //$location_array = ['52','50'];

        $query->andFilterWhere(['like', 'assessment2.status', $this->status]);
                $query->andFilterWhere(['in', 'assessment2.user_id', $location_array]);

        return $dataProvider;
    }
}
