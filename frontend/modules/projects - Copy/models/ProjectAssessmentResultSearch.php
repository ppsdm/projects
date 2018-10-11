<?php

namespace app\modules\projects\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\projects\models\ProjectAssessmentResult;
use common\modules\catalog\models\CatalogMeta;
use yii\data\SqlDataProvider;
/**
 * ProjectAssessmentResultSearch represents the model behind the search form about `app\modules\projects\models\ProjectAssessmentResult`.
 */
class ProjectAssessmentResultSearch extends ProjectAssessmentResult
{
    public $order;
     public $catalogmeta;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_assessment_id'], 'integer'],
               [['order', 'catalogmeta'], 'safe'],
            [['type', 'key', 'value', 'textvalue', 'attribute_1', 'attribute_2', 'attribute_3'], 'safe'],
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
        $query = ProjectAssessmentResult::find();
        $query
->joinWith('projectAssessment')
//->select('*, project_assessment_result.key as key, project_assessment.catalog_id as cat_id')
->joinWith('catalogMeta')
->where(
        '
        catalog_meta.catalog_id = project_assessment.catalog_id 
        AND catalog_meta.type = project_assessment_result.type 
        AND catalog_meta.value = project_assessment_result.key'
        )

        ;


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
            'project_assessment_id' => $this->project_assessment_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'textvalue', $this->textvalue])
            ->andFilterWhere(['like', 'attribute_1', $this->attribute_1])
            ->andFilterWhere(['like', 'attribute_2', $this->attribute_2])
            ->andFilterWhere(['like', 'attribute_3', $this->attribute_3]);


     
     $dataProvider->setSort([
        'attributes' => [
            //'ordervar',
            'order' => [

            //KOQ GA MAU KELUAR SORTING ORDERNYA
                'asc' => ['CAST(catalog_meta.attribute_3 as UNSIGNED)' => SORT_ASC],
                'desc' => ['CAST(catalog_meta.attribute_3 as UNSIGNED)' => SORT_DESC],
                'label' => 'Order',
                'default' => SORT_ASC
            ],
            /*
            'countryName' => [
                'asc' => ['tbl_country.country_name' => SORT_ASC],
                'desc' => ['tbl_country.country_name' => SORT_DESC],
                'label' => 'Country Name'
            ]
            */
        ],
        'defaultOrder' => [
            'order' => SORT_ASC
        ]
    ]);

        return $dataProvider;
    }
}
