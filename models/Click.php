<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Click extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%clicks}}';
    }

    public function rules(): array
    {
        return [
            [['ip', 'link_id'], 'required'],
            ['link_id', 'integer'],
            ['ip', 'string', 'max' => 50],
            [['user_agent', 'referrer'], 'string', 'max' => 512],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function getLink(): ActiveQuery
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }
}