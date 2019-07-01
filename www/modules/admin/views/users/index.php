<?php
/**
 * index.php
 *
 * Отображение пользователей списком
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 10:22
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $provider
 */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Users list';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', 'Users list');

echo Html::beginForm(['users/signup'], 'post');
echo Html::submitButton(Html::icon('plus') . ' Add', [
    'class' => 'btn btn-success',
    'name' => 'user-create',
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
        'username',
        'email'
    ],
]);