<?php

namespace app\components\validators;

use yii\httpclient\Client;
use yii\validators\Validator;

class UrlAvailabilityValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $url = $model->$attribute;

        if (!$this->isUrlAvailable($url)) {
            $this->addError($model, $attribute, 'Данный URL не доступен');
        }
    }

    protected function isUrlAvailable(string $url): bool
    {
        try {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('HEAD')
                ->setUrl($url)
                ->setOptions([
                    'timeout' => 5,
                    'followLocation' => true,
                    'maxRedirects' => 5,
                ])
                ->send();

            return $response->isOk;
        } catch (\Exception $e) {
            \Yii::error("URL availability check failed: {$e->getMessage()}");
            return false;
        }
    }
}