<?php


namespace App\Repositories;

use App\Models\NumberConversions;
use App\Repositories\ParamObj\NrConversionsRepoIndex;
use Illuminate\Support\Facades\Schema;

class NumberConversionsRepository implements NumberConversionsRepositoryInterface
{
    private NumberConversions $number_conversions;

    public function __construct(NumberConversions $number_conversions)
    {
        $this->number_conversions = $number_conversions;
    }

    public function incrementForValue(int $value) : void
    {
        $conversion = $this->number_conversions->firstOrCreate(['value' => $value]);
        $conversion->count++;
        $conversion->save();
    }

    /**
     * @param array $params - fields:array, sort_by:string, order_by:string
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(NrConversionsRepoIndex $params, bool $paginate = false)
    {
        $query = $this->number_conversions::query();

        //apply sort
        if($params->getOrderBy()&&$this->checkFieldsExists($params->getOrderBy()))
        {
            $query->orderBy($params->getOrderBy(), $params->getSortBy());
        }

        //check for specific fields requested
        if($this->checkFieldsExists($params->getFields()))
        {
            $query->select($params->getFields());
        }

        //check if paginate enable
        if($paginate)
        {
            return $query->paginate()->appends(request()->query());
        }

        //check limit number
        if($params->getLimit())
        {
            $query->limit($params->getLimit());
        }

        return $query->get();
    }

    public function checkFieldsExists(array $fields = [])
    {
        //get existing columns
        $table_columns = Schema::getColumnListing($this->number_conversions->getTable());

        //get the intersect
        $existing_column = array_intersect($fields, $table_columns);

        return count($existing_column) === count($fields);
    }

}
