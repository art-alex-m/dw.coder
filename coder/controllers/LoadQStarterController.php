<?php
/**
 * LoadQueueController.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 12:41
 */

namespace coder\controllers;

use coder\models\FilesListJob;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;
use yii\queue\file\Queue;

/**
 * Class LoadQueueController
 * Стартует очередь по скачиванию файлов
 * @package coder\controllers
 */
class LoadQStarterController extends Controller
{
    /**
     * Запускает выполнение очереди на скачивание файлов
     */
    public function actionIndex()
    {
        /** @var Queue $queue */
        $queue = Yii::$app->loadQueue;
        $queue->clear();

        $job = new FilesListJob();
        $id = $queue->push($job);
        Console::output($this->ansiFormat(
            Yii::t('app', 'Downloader job #{0} is started', $id), Console::FG_YELLOW));
    }
}