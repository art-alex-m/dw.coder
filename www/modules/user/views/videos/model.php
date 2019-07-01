<?php
/**
 * model.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 19:42
 *
 * @var \yii\web\View $this
 * @var \www\models\UploadVideoForm $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Upload new video');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-video">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-upload']); ?>

            <?= $form->field($model, 'file')->fileInput() ?>

            <div class="form-group">
                <?= Html::a(Yii::t('app', 'Cancel'), ['videos/index'],
                    ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton(Yii::t('app', 'Upload'),
                    ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>