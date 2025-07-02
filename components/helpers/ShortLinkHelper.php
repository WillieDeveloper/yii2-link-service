<?php

namespace app\components\helpers;

use yii\helpers\StringHelper;

class ShortLinkHelper
{
    const SHORT_CODE_LENGTH = 10;
    public static function generate(string $fullLink): string
    {
        return StringHelper::truncate(
            md5($fullLink . microtime()),
            self::SHORT_CODE_LENGTH,
            ''
        );
    }
}