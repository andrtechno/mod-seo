<?php

namespace panix\mod\seo\models\search;

use panix\engine\data\ActiveDataProvider;
use panix\mod\seo\models\Utm;

class UtmSearch extends Utm {


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['utm_content','utm_campaign','utm_term','utm_medium','utm_source'], 'string'],
            [['url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Utm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);


        $query->andFilterWhere(['like', 'utm_source', $this->utm_source]);

        return $dataProvider;
    }

}
