<?php
/**
 * RbacController.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 16:34
 */

namespace console\controllers;

use common\models\Rbac;
use yii\console\Controller;
use Yii;
use yii\helpers\Console;

/**
 * Class RbacController
 * Разворачивает права доступа
 * @package console\controllers
 */
class RbacController extends Controller
{
    /**
     * Разворачивает права доступа в приложении
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {
        $model = new Rbac();
        $model->create();
        Console::output($this->ansiFormat(Yii::t('app', 'RBAC permissions created')));
    }
}