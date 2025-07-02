<?php

namespace app\components\services;

use app\models\Click;
use app\models\Link;
use yii\db\ActiveRecordInterface;
use yii\db\Exception;
use yii\web\Request;

class ClickService implements ModelServiceInterface
{
    /**
     * @throws Exception
     */
    public function process(Request $request, ActiveRecordInterface $model): bool
    {
        $click = new Click([
            'ip' => $request->userIP,
            'user_agent' => $request->userAgent,
            'referrer' => $request->referrer,
        ]);

        $click->link('link', $model);

        return $click->save();
    }

    public function findByCode(string $code): ?Link
    {
        return Link::findByShortLink($code);
    }
}