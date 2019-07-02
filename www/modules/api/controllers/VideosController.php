<?php
/**
 * VideosController.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 15:48
 */

namespace www\modules\api\controllers;

use www\modules\api\components\Pagination;
use www\modules\api\models\Video;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

/**
 * Class VideosController
 * Контроллер для управления файлами
 * @package www\modules\api\controllers
 */
class VideosController extends Controller
{
    public $serializer = 'www\modules\api\components\Serializer';

    /**
     * Список видео для перекодирования
     * @return ActiveDataProvider
     */
    public function actionForDecode()
    {
        $query = Video::find()
            ->andWhere(['=', 'is_moderated', true])
            ->andWhere(['=', 'is_sent', false])
            ->orderBy(['created_at' => SORT_ASC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'for-decode' => ['get', 'options'],
        ];
    }
}