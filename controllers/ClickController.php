<?php

namespace app\controllers;

use app\models\Link;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ClickController extends Controller
{
    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionIndex(string $code): Response
    {
        $link = Link::findByShortLink($code);
        if ($link) {
            $link->logClick();
            return $this->redirect($link->full_body);
        }

        throw new NotFoundHttpException('URL не найден');
    }
}