<?php
/**
 * RemindVideoController.php
 *
 * Created by PhpStorm.
 * @date 04.07.19
 * @time 15:49
 */

namespace console\controllers;

use console\models\RemindVideoEmail;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;

/**
 * Class RemindVideoController
 * Напоминает администратору о просроченных немодерированных видео
 * @package console\controllers
 */
class RemindVideoController extends Controller
{
    /**
     * Отправляет письмо со списком видео для модерации
     */
    public function actionIndex()
    {
        $model = new RemindVideoEmail();
        $result = $model->send();
        if ($result > 0) {
            Console::output($this->ansiFormat(
                Yii::t('app', 'Email with {0} links was sent', $result)));
        }

        if ($result == 0) {
            Console::output($this->ansiFormat(Yii::t('app', 'No outdated video was found')));
        }

        if ($result < 0) {
            Console::output($this->ansiFormat(
                Yii::t('app', 'In the course of work there were errors. See log')));
            return ExitCode::DATAERR;
        }

        return ExitCode::OK;
    }
}