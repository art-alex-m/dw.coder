<?php
/**
 * FilesListJob.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 11:23
 */

namespace coder\models;

use coder\components\BuildUrlTrait;
use coder\components\FullQueueException;
use coder\components\QueueInfo;
use yii\base\BaseObject;
use yii\queue\RetryableJobInterface;
use Yii;

/**
 * Class FilesListJob
 * Формирует очередь для скачивания файлов
 * @package coder\models
 */
class FilesListJob extends BaseObject implements RetryableJobInterface
{
    use BuildUrlTrait;

    /** @var int время ожидания для нового запроса */
    public $delayTime = 30;
    /** @var int время ожидания при полной очереди */
    public $delayFullQTime = 120;

    /**
     * {@inheritdoc}
     */
    public function execute($queue)
    {
        $info = new QueueInfo(['queue' => $queue]);
        if (!$info->isEmpty) {
            throw new FullQueueException();
        }

        $urlStr = $this->buildUrl(Yii::$app->params['getVideosUrl'], [
            'offset' => 0,
            'limit' => 3,
        ]);
        $resp = file_get_contents($urlStr);
        $list = json_decode($resp, true);
        if (is_array($list)) {
            foreach ($list as $file) {
                if (isset($file['id'], $file['url'])) {
                    $queue->push(new DownloadJob($file));
                }
            }
        }
        $queue->delay($this->delayTime)->push($this);
    }

    /**
     * {@inheritdoc}
     */
    public function canRetry($attempt, $error)
    {
        return $error instanceof FullQueueException;
    }

    /**
     * {@inheritdoc}
     */
    public function getTtr()
    {
        return $this->delayFullQTime;
    }
}