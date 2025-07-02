<?php

namespace app\controllers;

use app\components\services\ModelServiceInterface;
use yii\filters\VerbFilter;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    protected ModelServiceInterface $service;

    public function __construct($id, $module, ModelServiceInterface $service, $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

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