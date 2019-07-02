<?php
/**
 * index.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 12:29
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $provider
 */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'My videos';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);

echo Html::a(Html::icon('plus') . ' ' . Yii::t('app', 'Add'), ['videos/create'], [
    'data-method' => 'post',
    'data-params' => ['video-create' => 1],
    'class' => 'btn btn-success',
]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '5%'],
        ],
        'title',
        [
            'attribute' => 'is_moderated',
            'value' => function ($item) {
                return Yii::t('app', $item->is_moderated ? 'True' : 'False');
            },
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd MMMM Y HH:mm:ss'],
            'label' => 'Upload date',
            'headerOptions' => ['width' => '15%'],
        ],
    ],
]);