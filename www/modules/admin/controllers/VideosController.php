<?php
/**
 * VideosController.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 10:32
 */

namespace www\modules\admin\controllers;

use common\models\Video;
use www\modules\admin\models\VideoSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

/**
 * Class VideosController
 * Контроллер для просмотра и управления видео
 * @package www\modules\admin\controllers
 */
class VideosController extends Controller
{
    /**
     * Просмотр всех видео списком
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();
        $provider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'provider' => $provider,
            'model' => $searchModel
        ]);
    }

    /**
     * Модерирует видео по идентификатору
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionModerate($id)
    {
        $model = Video::findOne($id);

        $cat = 'success';
        $msg = 'Video was successfully moderated';
        if (!$model instanceof Video) {
            $msg = 'Video not found by id #{0}';
            $cat = 'error';
        } else {
            if (!$model->is_moderated) {
                $model->is_moderated = true;
                $model->save();
            } else {
                $msg = 'Video #{0} is already moderated. Return';
                $cat = 'warning';
            }
        }

        Yii::$app->session->addFlash($cat, Yii::t('app', $msg, $id));

        return $this->redirect(['videos/index']);
    }

    /**
     * Удаление видео по идентификатору
     * @param int $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = Video::findOne($id);

        $cat = 'success';
        $msg = 'Video #{0} was successfully deleted';
        if (!$model instanceof Video) {
            $msg = 'Video not found by id #{0}';
            $cat = 'error';
        } else {
            if (!$model->is_sent) {
                $model->delete();
            } else {
                $msg = 'Video #{0} cannot be deleted. It was already decoded';
                $cat = 'warning';
            }
        }

        Yii::$app->session->addFlash($cat, Yii::t('app', $msg, $id));

        return $this->redirect(['videos/index']);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'moderate' => ['post'],
                ],
            ],
        ];
    }
}