<?php
/**
 * DownloadJob.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 10:02
 */

namespace coder\models;

use coder\components\BuildUrlTrait;
use common\components\ImplodePathTrait;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use Yii;

/**
 * Class DownloadJob
 * Скачивает файлы с публичного сервера
 *
 * @package coder\models
 * @property-read string $savedFile Имя файла для сохранения
 */
class DownloadJob extends BaseObject implements JobInterface
{
    use ImplodePathTrait,
        BuildUrlTrait;

    /** @var string URL для загрузки файла */
    public $url;
    /** @var int Идентификатор скачиваемого файла в базе */
    public $id;
    /** @var string Имя исходного файла */
    public $title;
    /** @var string Имя файла для сохранения */
    protected $path;

    /**
     * {@inheritdoc}
     */
    public function execute($queue)
    {
        /// FIXME: Для тестового задания используем простыую обертку для сохранения файлов
        $res = file_put_contents($this->savedFile, file_get_contents($this->url));
        if (false !== $res) {
            Yii::$app->coderQueue->push(new DecodeJob(['file' => $this->savedFile]));
            $url = $this->buildUrl(Yii::$app->params['setVideoLoad'], ['id' => $this->id]);
            $context = stream_context_create([
                'http' => [
                    'method' => 'put',
                    'header' => 'Authorization: Bearer ' . Yii::$app->params['adminAuthToken'],
                ]
            ]);
            file_get_contents($url, false, $context);
        }
    }

    /**
     * Имя файла для сохранения
     * @return bool|string
     * @throws \Exception
     */
    public function getSavedFile()
    {
        if (empty($this->path)) {
            $name = basename($this->url);
            $date = new \DateTime();
            $path = Yii::getAlias($this->implodePath(DIRECTORY_SEPARATOR, [
                Yii::$app->params['uploadDir'],
                [$date->format('m'), $date->format('d')],
            ]));
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $this->path = $path . DIRECTORY_SEPARATOR . $name;
        }
        return $this->path;
    }
}