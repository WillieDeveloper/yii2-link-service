<?php

namespace app\components\services;

use yii\db\ActiveRecordInterface;
use yii\web\Request;

class LinkService implements ModelServiceInterface
{

    public function process(Request $request, array $params = []): bool
    {
        return !empty($params);
    }

    public function getRedirectLink(): string
    {
        return '';
    }
}