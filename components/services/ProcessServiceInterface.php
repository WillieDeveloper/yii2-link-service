<?php

namespace app\components\services;

use yii\web\Request;

interface ProcessServiceInterface
{
    public function process(Request $request, array $params = []): bool;
}