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

$this->title = Yii::t('app', 'Users list');
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);

echo Html::a(Html::icon('plus') . ' ' . Yii::t('app', 'Add'), ['users/signup'], [
    'data-method' => 'post',
    'data-params' => ['user-create' => 1],
    'class' => 'btn btn-success',
]);

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