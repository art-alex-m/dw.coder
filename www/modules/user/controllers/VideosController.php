<?php
/**
 * VideosController.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 12:27
 */

namespace www\modules\user\controllers;

use www\models\UploadVideoForm;
use Yii;
use common\models\Video;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class VideosController
 * Контроллер по управлению файлами пользователя
 * @package www\modules\users\controllers
 */
class VideosController extends Controller
{
    /**
     * Просмотр видео пользователя списком
     * @return string
     */
    public function actionIndex()
    {
        $query = Video::find()->andWhere(['=', 'user_id', (int)Yii::$app->user->getId()]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->render('index', ['provider' => $provider]);
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
                    'create' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Загрузка файла на сервер
     * @return string
     */
    public function actionCreate()
    {
        $model = new UploadVideoForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['videos/index']);
        }
        return $this->render('model', ['model' => $model]);
    }
}