<?php

namespace app\models;

use app\components\helpers\ShortLinkHelper;
use app\components\validators\UrlAvailabilityValidator;
use app\models\ActiveRecord\Link as ActiveRecordLink;

class Link extends ActiveRecordLink
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = ['full_body', UrlAvailabilityValidator::class];
        return $rules;
    }

    protected function saveShortLink(): void
    {
        $this->short_body = ShortLinkHelper::generate($this->getFullLink());
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->saveShortLink();
        }
        return true;

    }

    public static function findByFullLink($url): ?Link
    {
        return static::findOne(['full_body' => $url]);
    }

    public static function findByShortLink(string $code): ?Link
    {
        return static::findOne(['short_body' => $code]);
    }

    public function getClicksCount(): int
    {
        return $this->clicks_count;
    }

    public function getFullLink(): string
    {
        return $this->full_body;
    }

    public function getShortLink(): string
    {
        return $this->short_body;
    }

    public function getId(): int
    {
        return $this->id;
    }
}