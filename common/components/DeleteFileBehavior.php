<?php
/**
 * DeleteFileBehavior.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 12:23
 */

namespace common\components;

use yii\base\Behavior;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class DeleteFileBehavior
 * Удаляет файл после удаления записи в базе
 * @package common\components
 */
class DeleteFileBehavior extends Behavior
{
    use ImplodePathTrait;

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteFile',
        ];
    }

    /**
     * Удаляет файл
     * @param ModelEvent $event
     */
    public function deleteFile($event)
    {
        $model = $event->sender;
        $path = $this->implodePath(DIRECTORY_SEPARATOR,
            [Yii::$app->params['uploadDir'], $model->path]);
        $path = Yii::getAlias($path);
        if (file_exists($path)) {
            unlink($path);
        }
    }
}