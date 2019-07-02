<?php
/**
 * VideoSearch.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 10:56
 */

namespace www\modules\admin\models;

use common\models\Video;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class VideoSearch
 * Модель для формирования поисковых запросов по видео
 * @package www\modules\admin\models
 */
class VideoSearch extends Video
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Video::tableName();
    }

    /**
     * Формирует провайдер данных для отображения в гриде
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $provider;
        }

        $query->andFilterWhere(['=', 'is_moderated', $this->is_moderated]);
        $query->andFilterWhere(['=', 'is_sent', $this->is_sent]);

        return $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_moderated', 'is_sent'], 'boolean'],
        ];
    }

    /**
     * Формирует список для логического фильтра
     * @return array
     */
    public function getBoolFilter()
    {
        return [
            Yii::t('app', 'False'),
            Yii::t('app', 'True')
        ];
    }
}