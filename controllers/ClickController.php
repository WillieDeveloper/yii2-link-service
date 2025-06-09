<?php

namespace app\controllers;

use app\models\Link;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ClickController extends BaseController
{
    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionIndex(string $code): Response
    {
        $link = Link::findByShortLink($code);
        if ($link) {
            $link->logClick(Yii::$app->request);
            return $this->redirect($link->full_body);
        }

        throw new NotFoundHttpException('URL не найден');
    }
}