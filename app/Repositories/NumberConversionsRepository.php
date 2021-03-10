<?php


namespace App\Repositories;

use App\Models\NumberConversions;
use Illuminate\Support\Facades\Log;
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
    public function index(array $params, bool $paginate = false)
    {
        $query = $this->number_conversions::query();

        //apply sort
        if(isset($params['sort_by'])&&!empty($params['sort_by'])&&$this->checkFieldsExists([$params['sort_by']]))
        {
            $query->orderBy($params['sort_by'], in_array($params['order_by'], ['ASC', 'DESC']) ? $params['order_by'] : 'ASC');
        }

        //check for specific fields requested
        $fields = explode(',', $params['fields'] ?? '');
        if(array_filter($fields)&&$this->checkFieldsExists($fields))
        {
            $query->select($fields);
        }

        //check if paginate enable
        if($paginate)
        {
            return $query->paginate()->appends(request()->query());
        }

        //check limit number
        if(isset($params['limit'])&&!empty($params['limit']))
        {
            $query->limit($params['limit']);
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
