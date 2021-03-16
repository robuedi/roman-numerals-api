<?php


namespace App\Repositories\Functionalities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class FieldsExists implements FieldsExistsInterface
{
    private Model $model;

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function checkFieldsExists(array $fields = []) : bool
    {
        //get existing columns
        $table_columns = Schema::getColumnListing($this->model->getTable());

        //get the intersect
        $existing_column = array_intersect($fields, $table_columns);

        return count($existing_column) === count($fields);
    }
}
