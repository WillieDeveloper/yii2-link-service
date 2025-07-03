<?php

namespace app\components\services;

use app\models\Click;
use app\models\Link;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class ClickService extends BaseService
{
    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function process(Request $request, array $params = []): bool
    {
        $this->model = $this->findByCode($params['code']);
        if ($this->model === null) {
            throw new NotFoundHttpException('URL не найден');
        }
        $click = new Click([
            'ip' => $request->userIP,
            'user_agent' => $request->userAgent,
            'referrer' => $request->referrer,
        ]);
        $click->link('link', $this->model);
        return $click->save();
    }

    protected function findByCode(string $code): ?Link
    {
        return Link::findByShortLink($code);
    }

    public function getData(): array
    {
        return ['redirectLink' => $this->model->getFullLink()];
    }

    protected function getModelClass(): string
    {
        return Link::class;
    }
}