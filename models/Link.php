<?php

namespace app\models;

use app\components\validators\UrlAvailabilityValidator;
use app\models\AR\Link as ARLink;
use Yii;
use yii\db\Exception;
use yii\helpers\StringHelper;
use yii\web\Request;

class Link extends ARLink
{
    const SHORT_CODE_LENGTH = 10;
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = ['full_body', UrlAvailabilityValidator::class];
        return $rules;
    }

    public function generateShortCode(): void
    {
        $this->short_body = StringHelper::truncate(
            md5($this->full_body . microtime()),
            self::SHORT_CODE_LENGTH,
            ''
        );
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->generateShortCode();
        }
        return true;

    }

    public function getShortUrl(): string
    {
        return Yii::$app->urlManager->createAbsoluteUrl(['click/index', 'code' => $this->short_body]);
    }

    /**
     * @throws Exception
     */
    public function logClick(Request $request): void
    {
        $click = new Click([
            'link_id' => $this->id,
            'ip' => $request->userIP,
            'user_agent' => $request->userAgent,
            'referrer' => $request->referrer,
        ]);

        $click->save();
    }

    public static function findByFullLink($url): ?Link
    {
        return static::findOne(['full_body' => $url]);
    }

    public static function findByShortLink(string $code): ?Link
    {
        return static::findOne(['short_body' => $code]);
    }

    public function getClicksCount()
    {
        return $this->clicks_count;
    }
}