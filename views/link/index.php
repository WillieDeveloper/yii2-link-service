<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\Link $model */

use app\assets\CopyToClipboardAsset;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

CopyToClipboardAsset::register($this);
$this->title = 'Get short link & QR';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

        <?php Pjax::begin(['id' => 'link-form-pjax', 'timeout' => false]) ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <?php $success = Yii::$app->session->getFlash('success') ?>
            <div class="alert alert-success">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center">
                        <?= Html::img($success['qrCode'], [
                            'alt' => 'QR Code',
                            'class' => 'img-fluid mb-2',
                            'style' => 'max-width: 200px;'
                        ]) ?>
                        <p class="mb-0">Наведите камеру телефона на QR-код</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Ваша короткая ссылка:</h4>
                        <div class="input-group mb-3">
                            <?= Html::a($success['shortUrl'], $success['shortUrl'], [
                                    'id' => 'short_url',
                                    'class' => 'form-control',
                                    'target' => '_blank',
                                    'style' => 'overflow: hidden; text-overflow: ellipsis;'
                                ]
                            ) ?>
                            <?= Html::button('Копировать', [
                                    'id' => 'short_url-copy_btn',
                                    'class' => 'btn btn-outline-secondary'
                                ]
                            ) ?>
                        </div>
                        <p class="small text-muted">Всего переходов: <?= $success['clicksCount'] ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php $form = ActiveForm::begin([
            'id' => 'link-form',
            'options' => ['data-pjax' => true],
        ]); ?>

        <div class="input-group mb-3">
            <?= $form->field($model, 'full_body', [
                'template' => "{input}\n{error}",
                'options' => ['class' => 'form-group flex-grow-1 mb-0'],
            ])->textInput([
                'placeholder' => 'Введите URL для сокращения',
                'class' => 'form-control'
            ])->label(false) ?>

            <div class="input-group-append">
                <?= Html::submitButton('OK', [
                    'class' => 'btn btn-primary',
                    'id' => 'shorten-button'
                ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <?php Pjax::end() ?>
    </div>
</div>
