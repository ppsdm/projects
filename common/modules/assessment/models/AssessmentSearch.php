<?php

namespace common\modules\assessment\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\modules\assessment\models\Assessment;
use common\modules\catalog\models\CatalogGeneral;

/**
 * AssessmentSearch represents the model behind the search form about `app\modules\assessment\models\Assessment`.
 */
class AssessmentSearch extends Assessment
{

    public $catalog_name = '';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'catalog_id'], 'integer'],
                        [['catalog_name'], 'string'],
            [['status', 'timestamp'], 'safe'],
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

$cat_name = '';
if(array_key_exists('catalog_name', $params['AssessmentSearch'])){

//print_r($params);
    $cat_name = $params['AssessmentSearch']['catalog_name'];
}
        $catalog_search = CatalogGeneral::find()->andWhere(['like','name', $cat_name])->asArray()->All();
        $catalog_array = ArrayHelper::getColumn($catalog_search, 'id');

if (sizeof($catalog_search) > 0) {
$search_array = $catalog_array;
} else {
$search_array = ['-'];
}

//print_r($catalog_array);
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
            'user_id' => $this->user_id,
            //'catalog_id' => $this->catalog_id,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);
                $query->andFilterWhere(['in', 'catalog_id', $search_array]);
                //echo 'saaaaaaaaddddddddddddddd';
//print_r($catalog_array);
        return $dataProvider;
    }
}
