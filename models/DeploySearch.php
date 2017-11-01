<?php

namespace nahard\deploy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use nahard\deploy\models\Deploy;

/**
 * DeploySearch represents the model behind the search form about `nahard\deploy\models\Deploy`.
 */
class DeploySearch extends Deploy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['request_ip', 'request_data', 'request_url', 'message'], 'safe'],
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
        $query = Deploy::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => ['defaultOrder'=>['id'=>SORT_DESC]]
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'request_ip', $this->request_ip])
            ->andFilterWhere(['like', 'request_data', $this->request_data])
            ->andFilterWhere(['like', 'request_url', $this->request_url])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
