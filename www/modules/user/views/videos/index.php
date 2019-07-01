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

echo Html::tag('h1', 'My videos');

echo Html::beginForm(['videos/create'], 'post');
echo Html::submitButton(Html::icon('plus') . ' Add', [
    'class' => 'btn btn-success',
    'name' => 'video-create',
    'value' => 1,
]);
echo Html::endForm();

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '5%'],
        ],
        'title',
        'is_moderated',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd MMMM Y HH:mm:ss'],
            'label' => 'Upload date',
            'headerOptions' => ['width' => '15%'],
        ],
    ],
]);