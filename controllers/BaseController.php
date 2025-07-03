<?php

namespace app\controllers;

use app\components\services\ModelServiceInterface;
use yii\filters\VerbFilter;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    protected ModelServiceInterface $service;

    public function __construct($id, $module, $config = [])
    {
        $serviceClass = $this->getServiceClass();
        $this->service = new $serviceClass();

        parent::__construct($id, $module, $config);
    }

    abstract protected function getServiceClass(): string;

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