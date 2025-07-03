<?php

namespace app\components\services;

use app\models\Click;
use app\models\Link;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class ClickService implements ModelServiceInterface
{
    private ?Link $linkModel;
    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function process(Request $request, array $params = []): bool
    {
        $this->linkModel = $this->findByCode($params['code']);
        if ($this->linkModel === null) {
            throw new NotFoundHttpException('URL не найден');
        }
        $click = new Click([
            'ip' => $request->userIP,
            'user_agent' => $request->userAgent,
            'referrer' => $request->referrer,
        ]);
        $click->link('link', $this->linkModel);
        return $click->save();
    }

    protected function findByCode(string $code): ?Link
    {
        return Link::findByShortLink($code);
    }

    public function getRedirectLink(): string
    {
        return $this->linkModel->getFullLink();
    }
}