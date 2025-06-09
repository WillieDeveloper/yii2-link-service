<?php

namespace app\models\AR;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Link extends ActiveRecord
{
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
            ['full_body', 'required', 'message' => 'URL не может быть пустым'],
            ['full_body', 'string', 'max' => 767],
            ['short_body', 'string', 'max' => 20],
            ['clicks_count', 'integer'],
            ['clicks_count', 'default', 'value'=> 0],
            [['full_body', 'short_body'], 'unique'],
            [['full_body'], 'url', 'validSchemes' => ['http', 'https'], 'message' => 'Введите корректный URL'],
        ];
    }

    public function getClicks(): ActiveQuery
    {
        return $this->hasMany(Click::class, ['link_id' => 'id']);
    }
}