<?php
/**
 * Video.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 16:07
 */

namespace www\modules\api\models;

use yii\helpers\Url;

/**
 * Class Video
 * Прокси класс для видео при работе с api
 * @package www\modules\api\models
 */
class Video extends \common\models\Video
{
    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'id',
            'url',
            'title',
        ];
    }

    /**
     * Создает абсолютную ссылку на скачивание файла
     * @return string
     */
    public function getUrl()
    {
        return Url::to($this->getUri(), true);
    }
}