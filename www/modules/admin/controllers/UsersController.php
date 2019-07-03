<?php
/**
 * UsersController.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 10:17
 */

namespace www\modules\admin\controllers;

use common\models\Rbac;
use common\models\SignupForm;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class UsersController
 * Контроллер по управлению пользователями системы
 *
 * @package www\modules\admin\controllers
 */
class UsersController extends Controller
{
    /**
     * Отображение пользователей списком
     * @return string
     */
    public function actionIndex()
    {
        $query = User::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['username' => SORT_ASC]],
        ]);
        return $this->render('index', ['provider' => $provider]);
    }

    /**
     * Регистрировет нового пользователя
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::PERMISSION_ADMIN],
                    ],
                ],
            ],
        ];
    }
}