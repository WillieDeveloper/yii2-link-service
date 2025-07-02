<?php

namespace app\controllers;

use app\components\helpers\UrlHelper;
use app\components\services\QrCodeService;
use app\models\Link;
use Yii;
use yii\db\Exception;
class LinkController extends BaseController
{
    /**
     * @throws Exception
     */
    public function actionIndex(): string
    {
        $model = new Link();
        $request = Yii::$app->getRequest();

        if ($request->isPost && $model->load($request->post())) {
            $model = Link::findByFullLink($model->getFullLink()) ?? $model;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', [
                    'shortUrl' => UrlHelper::getShortUrl($model->getShortLink()),
                    'qrCode' => QrCodeService::generateQrCode(UrlHelper::getShortUrl($model->getShortLink())),
                    'clicksCount' => $model->getClicksCount(),
                ]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка при сохранении URL'));
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}