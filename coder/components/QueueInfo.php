<?php
/**
 * QueueInfo.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 11:59
 */

namespace coder\components;

use yii\base\BaseObject;

/**
 * Class QueueInfo
 * Получает состояние файловой очереди
 * @package coder\components
 * @property-read int $waitingCount
 * @property-read int $delayedCount
 * @property-read int $reservedCount
 * @property-read int $doneCount
 * @property-read int $totalCount
 * @property-read bool $isEmpty
 */
class QueueInfo extends BaseObject
{
    /** @var \yii\queue\file\Queue Очередь */
    public $queue;

    /**
     * Есть ли в очереди задания
     * @return bool
     */
    public function getIsEmpty()
    {
        return ($this->delayedCount + $this->waitingCount) <= 0;
    }

    /**
     * Получает количество ожидающих заданий в очереди
     * @return int
     */
    public function getWaitingCount()
    {
        $data = $this->getIndexData();
        return !empty($data['waiting']) ? count($data['waiting']) : 0;
    }

    /**
     * Количество отложенных заданий
     * @return int
     */
    public function getDelayedCount()
    {
        $data = $this->getIndexData();
        return !empty($data['delayed']) ? count($data['delayed']) : 0;
    }

    /**
     * Количество зарезервированных заданий
     * @return int
     */
    public function getReservedCount()
    {
        $data = $this->getIndexData();
        return !empty($data['reserved']) ? count($data['reserved']) : 0;
    }

    /**
     * Количество выполненных заданий
     * @return int|mixed
     */
    public function getDoneCount()
    {
        return $this->totalCount - $this->getDelayedCount() - $this->getWaitingCount();
    }

    /**
     * Возвращает общее число заданий в очереди
     * @return int
     */
    public function getTotalCount()
    {
        $data = $this->getIndexData();
        return isset($data['lastId']) ? $data['lastId'] : 0;
    }

    /**
     * Распарсивает данные по очереди
     * @return array|mixed|null
     */
    protected function getIndexData()
    {
        static $data;
        if ($data === null) {
            $fileName = $this->queue->path . '/index.data';
            if (file_exists($fileName)) {
                $data = call_user_func($this->queue->indexDeserializer,
                    file_get_contents($fileName));
            } else {
                $data = [];
            }
        }

        return $data;
    }
}