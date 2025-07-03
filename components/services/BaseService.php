<?php

namespace app\components\services;

use yii\db\ActiveRecordInterface;
use yii\web\Request;

abstract class BaseService implements ProcessServiceInterface, DataServiceInterface
{
    protected ?ActiveRecordInterface $model;
    abstract public function process(Request $request, array $params = []): bool;
    abstract public function getData(): array;

    public function getModel(): ?ActiveRecordInterface
    {
        return $this->model;
    }

    public function __construct()
    {
        $model = $this->getModelClass();
        $this->model = new $model();
    }

    abstract protected function getModelClass(): string;
}