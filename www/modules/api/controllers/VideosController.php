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
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;
use Yii;

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
     * Отмечает, что видео файл был получен обработчиком
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function actionDownloaded($id)
    {
        $model = Video::findOne($id);
        if (!$model instanceof Video) {
            $msg = 'Video not found by id #{0}';
            throw new NotFoundHttpException(Yii::t('app', $msg, $id));
        } else {
            if ($model->is_moderated) {
                $model->is_sent = true;
                $model->save();
            } else {
                throw new UnprocessableEntityHttpException(
                    Yii::t('app', 'Video #{0} should be moderated first', $id));
            }
        }
        return ['saved' => true];
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'for-decode' => ['get', 'options'],
            'downloaded' => ['put'],
        ];
    }
}