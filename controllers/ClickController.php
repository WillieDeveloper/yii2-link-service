<?php

namespace app\controllers;

use app\components\services\ClickService;
use Yii;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class ClickController extends BaseController
{
    /**
     * @throws ServerErrorHttpException
     */
    public function actionIndex(string $code): Response
    {
        if (!$this->service->process(Yii::$app->request, ['code' => $code])) {
            throw new ServerErrorHttpException('Ошибка сохранения клика');
        }

        return $this->redirect($this->service->getRedirectLink());
    }

    protected function getServiceClass(): string
    {
        return ClickService::class;
    }
}