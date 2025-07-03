<?php

namespace app\controllers;

use app\components\services\LinkService;
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
        $request = Yii::$app->getRequest();

        if ($request->isPost) {
            if ($this->service->process($request)) {
                Yii::$app->session->setFlash('success', $this->service->getData());
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка при сохранении URL'));
            }
        }

        return $this->render('index', [
            'model' => $this->service->getModel(),
        ]);
    }

    protected function getServiceClass(): string
    {
        return LinkService::class;
    }
}