<?php
/**
 * DecodeJob.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 11:42
 */

namespace coder\models;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class DecodeJob extends BaseObject implements JobInterface
{
    /** @var string Путь к файлу для перекодирования */
    public $file;

    /**
     * {@inheritdoc}
     */
    public function execute($queue)
    {

    }
}