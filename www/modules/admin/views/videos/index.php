<?php
/**
 * index.php
 *
 * Список видео в панеле администратора
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 10:33
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $provider
 * @var \www\modules\admin\models\VideoSearch $model
 */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Videos');
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);

echo GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($item) {
                return Html::a($item->title, $item->uri);
            }
        ],
        [
            'attribute' => 'is_moderated',
            'value' => function ($item) {
                return Yii::t('app', $item->is_moderated ? 'True' : 'False');
            },
            'filter' => $model->getBoolFilter(),
        ],
        [
            'attribute' => 'is_sent',
            'value' => function ($item) {
                return Yii::t('app', $item->is_sent ? 'True' : 'False');
            },
            'filter' => $model->getBoolFilter(),
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd MMMM Y HH:mm:ss'],
            'label' => 'Upload date',
            'headerOptions' => ['width' => '15%'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['class' => 'action-column', 'width' => '50'],
            'template' => '{moderate}&nbsp;{delete}',
            'buttons' => [
                'moderate' => function ($url, $model, $key) {
                    if (!$model->is_moderated) {
                        $url = Url::to(['videos/moderate', 'id' => $model->id]);
                        return Html::a(Html::icon('ice-lolly-tasted'), $url,
                            [
                                'title' => Yii::t('app', 'Moderate video'),
                                'data-confirm' => Yii::t('app',
                                    'Do you want to moderate this video?'),
                                'data-method' => 'post',
                            ]
                        );
                    }
                    return false;
                },
                'delete' => function ($url, $model, $key) {
                    if (!$model->is_sent) {
                        return Html::a(Html::icon('trash'), $url,
                            [
                                'title' => Yii::t('app', 'Delete'),
                                'data-confirm' => Yii::t('yii',
                                    'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                            ]
                        );
                    }
                    return false;
                }
            ]
        ],
    ],
]);