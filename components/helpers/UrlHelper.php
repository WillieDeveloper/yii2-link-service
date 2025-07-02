<?php

namespace app\components\helpers;

use Yii;

class UrlHelper
{
    public static function getShortUrl(string $code): string
    {
        return Yii::$app->urlManager->createAbsoluteUrl(['click/index', 'code' => $code]);
    }
}