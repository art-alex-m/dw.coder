<?php
/**
 * UploadTimeLimitValidator.php
 *
 * Created by PhpStorm.
 * @date 04.07.19
 * @time 19:08
 */

namespace www\components;

use yii\validators\Validator;
use common\models\Video;
use Yii;

/**
 * Class UploadTimeLimitValidator
 * Проверяет что можно загружать видео раз в 7 дней
 * @package www\components
 */
class UploadTimeLimitValidator extends Validator
{
    /**
     * {@inheritdoc}
     */
    protected function validateValue($value)
    {
        $userId = Yii::$app->user->getId();
        if ($userId) {
            $date = (new \DateTime())->modify('-7 days');
            $model = Video::find()
                ->andWhere(['=', 'user_id', $userId])
                ->andWhere(['>', 'created_at', $date->format(DATE_RFC3339)])
                ->one();
            if (!$model instanceof Video) {
                return null;
            }
        }
        return [
            'Possible to load video once in 7 days. Sorry...',
            []
        ];
    }
}