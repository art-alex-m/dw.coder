<?php
/**
 * remindVideoEmail-text.php
 *
 * Created by PhpStorm.
 * @date 04.07.19
 * @time 16:31
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $provider
 * @var Video $video
 */

use common\models\Video;
use yii\helpers\Url;

echo 'Videos requied moderation:';
echo PHP_EOL;

foreach ($provider->getModels() as $i => $video) {
    $i++;
    echo "$i. ";
    echo Url::to($video->getUri(), true);
    echo PHP_EOL;
}