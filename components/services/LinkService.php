<?php

namespace app\components\services;

use app\components\helpers\UrlHelper;
use app\models\Link;
use yii\db\Exception;
use yii\web\Request;

class LinkService extends BaseService
{
    /**
     * @throws Exception
     */
    public function process(Request $request, array $params = []): bool
    {
        $model = new Link();
        if ($model->load($request->post())) {
            $this->model = Link::findByFullLink($model->getFullLink()) ?? $this->model;
        }
        return $this->model->save();
    }

    public function getData(): array
    {
        return [
            'shortUrl' => UrlHelper::getShortUrl($this->model->getShortLink()),
            'qrCode' => QrCodeService::generateQrCode(UrlHelper::getShortUrl($this->model->getShortLink())),
            'clicksCount' => $this->model->getClicksCount(),
        ];
    }

    protected function getModelClass(): string
    {
        return Link::class;
    }
}