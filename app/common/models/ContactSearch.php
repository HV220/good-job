<?php

declare(strict_types=1);

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContactSearch represents the model behind the search form of `common\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * {@inheritdoc}
     */
    public string $username;
    public string $email;
    public int $created_at;
    public mixed $myPageSize = null;


    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['title', 'myPageSize'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
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
    public function search($params): ActiveDataProvider
    {
        $query = Contact::find();
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'created_at',
                ],
            ],
        ]);

        $this->load($params);

        $dataProvider->pagination->pageSize = ($this->myPageSize !== null) ? $this->myPageSize : 10;

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([

        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'message', $this->message])
            ->andFilterWhere(['ilike', 'user.email', $this->user])
            ->andFilterWhere(['ilike', 'user.username', $this->user])
            ->andFilterWhere(['ilike', 'user.created_at', $this->user]);

        return $dataProvider;
    }
}

