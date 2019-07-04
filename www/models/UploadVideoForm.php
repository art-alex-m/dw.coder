<?php
/**
 * UploadVideoForm.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 17:20
 */

namespace www\models;

use common\components\ImplodePathTrait;
use common\models\Video;
use www\components\UploadTimeLimitValidator;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadVideoForm
 * Модель для загрузки файлов
 * @package www\models
 */
class UploadVideoForm extends Model
{
    use ImplodePathTrait;

    /** @var UploadedFile */
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file', 'required'],
            ['file', 'file'],
            ['file', UploadTimeLimitValidator::class],
        ];
    }

    /**
     * Сохранение файла
     * @return bool
     * @throws \yii\base\Exception
     */
    public function save()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->validate()) {
            $fileName = $this->getFileName();
            $savedFile = Yii::getAlias($this->getSavePath($fileName));
            $dir = dirname($savedFile);
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            if ($this->file->saveAs($savedFile)) {
                $file = new Video([
                    'title' => $this->file->name,
                    'path' => $this->implodePath(DIRECTORY_SEPARATOR,
                        [$this->getPath(), $fileName]),
                    'user_id' => (int)Yii::$app->user->getId(),
                ]);
                $file->save();
                if ($file->hasErrors()) {
                    $errors = $file->getFirstErrors();
                    $this->addError('file', reset($errors));
                    unlink($savedFile);
                } else {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Новое имя файла
     * @return string
     * @throws \yii\base\Exception
     */
    protected function getFileName()
    {
        $name = strtolower(Yii::$app->security->generateRandomString(16));
        $name = strtr($name, '-_', '58');
        $name .= '.' . strtolower($this->file->extension);

        return $name;
    }

    /**
     * Относительный путь для хранения файлов
     * @return array
     * @throws \Exception
     */
    protected function getPath()
    {
        $date = new \DateTime();
        return [$date->format('m'), $date->format('d')];
    }

    /**
     * Возвращает полный путь для сохранения файла
     * @param string $fileName
     * @return string
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    protected function getSavePath($fileName)
    {
        return $this->implodePath(DIRECTORY_SEPARATOR,
            [Yii::$app->params['uploadDir'], $this->getPath(), $fileName]);
    }
}