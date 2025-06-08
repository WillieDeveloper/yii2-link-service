<?php

namespace app\models;

use Da\QrCode\QrCode;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\StringHelper;
use app\components\validators\UrlAvailabilityValidator;

class Link extends ActiveRecord
{
    const SHORT_CODE_LENGTH = 10;

    public static function tableName(): string
    {
        return '{{%links}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            ['full_body', 'required'],
            ['full_body', 'string', 'max' => 767],
            ['short_body', 'string', 'max' => 20],
            ['clicks_count', 'integer'],
            ['clicks_count', 'default', 'value'=> 0],
            [['full_body', 'short_body'], 'unique'],
            [['full_body'], 'url', 'validSchemes' => ['http', 'https']],
            ['full_body', UrlAvailabilityValidator::class],
        ];
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
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateShortCode();
            }
            return true;
        }
        return false;
    }

    public static function findByFullLink($url): ?Link
    {
        return static::findOne(['full_body' => $url]);
    }

    public static function findByShortLink(string $code): ?Link
    {
        return static::findOne(['short_body' => $code]);
    }

    public function getShortUrl(): string
    {
        return Yii::$app->urlManager->createAbsoluteUrl(['click/index', 'code' => $this->short_body]);
    }

    public function getQrCode(int $size = 200): string
    {
        $qrCode = (new QrCode($this->getShortUrl()))
            ->setSize($size)
            ->setMargin(5)
            ->setBackgroundColor(240, 240, 240);

        return $qrCode->writeDataUri();
    }

    /**
     * @throws Exception
     */
    public function logClick(): void
    {
        $click = new Click([
            'link_id' => $this->id,
            'ip' => Yii::$app->request->userIP,
            'user_agent' => Yii::$app->request->userAgent,
            'referrer' => Yii::$app->request->referrer,
        ]);

        $click->save();
    }

    public function getClicks(): ActiveQuery
    {
        return $this->hasMany(Click::class, ['link_id' => 'id']);
    }

    public function getClicksCount()
    {
        return $this->clicks_count;
    }
}