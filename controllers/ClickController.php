<?php

namespace app\controllers;

use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class ClickController extends BaseController
{
    /**
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws ServerErrorHttpException
     */
    public function actionIndex(string $code): Response
    {
        $link = $this->service->findByCode($code);
        if ($link === null) {
            throw new NotFoundHttpException('URL не найден');
        }

        if ($this->service->process(Yii::$app->request, $link)) {
            throw new ServerErrorHttpException('Ошибка сохранения клика');
        }

        return $this->redirect($link->getFullLink());
    }
}