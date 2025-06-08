<?php

namespace app\controllers;

use app\models\Link;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class LinkController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex(): string
    {
        $model = new Link();
        $request = Yii::$app->getRequest();

        if ($request->isPost && $model->load($request->post())) {
            $model = Link::findByFullLink($model->full_body) ?? $model;

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', [
                        'shortUrl' => $model->getShortUrl(),
                        'qrCode' => $model->getQrCode(),
                        'clicksCount' => $model->getClicksCount(),
                    ]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении URL');
                }
            } else {
                Yii::$app->session->setFlash('error', $this->getErrorMessages($model));
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    protected function getErrorMessages($model): string
    {
        $errors = [];
        foreach ($model->getErrors() as $messages) {
            $errors[] = implode(' ', $messages);
        }
        return implode('<br>', $errors);
    }
}