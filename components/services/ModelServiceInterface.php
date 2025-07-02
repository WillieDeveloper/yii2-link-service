<?php

namespace app\components\services;

use yii\db\ActiveRecordInterface;
use yii\web\Request;

interface ModelServiceInterface
{
    public function process(Request $request, ActiveRecordInterface $model): bool;
}