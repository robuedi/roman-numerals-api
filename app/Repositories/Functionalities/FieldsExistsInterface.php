<?php

namespace App\Repositories\Functionalities;

use Illuminate\Database\Eloquent\Model;

interface FieldsExistsInterface
{
    /**
     * @param Model $model
     */
    public function setModel(Model $model): void;

    public function checkFieldsExists(array $fields = []): bool;
}
