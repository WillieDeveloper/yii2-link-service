<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                ],
            ],
        ];
    }
}