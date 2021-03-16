<?php


namespace App\Repositories;

use App\Models\NumberConversions;
use App\Repositories\Functionalities\FieldsExistsInterface;
use App\Repositories\ParamObj\NrConversionsRepoIndexInterface;

class NumberConversionsRepository implements NumberConversionsRepositoryInterface
{
    private NumberConversions $number_conversions;
    private FieldsExistsInterface $fields_exists;

    public function __construct(NumberConversions $number_conversions, FieldsExistsInterface $fields_exists)
    {
        $this->number_conversions   = $number_conversions;
        $this->fields_exists        = $fields_exists;
        $this->fields_exists->setModel($number_conversions);
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
    public function index(NrConversionsRepoIndexInterface $params, bool $paginate = false)
    {
        $query = $this->number_conversions::query();

        //apply sort
        if($params->getOrderBy()&&$this->fields_exists->checkFieldsExists($params->getOrderBy()))
        {
            $query->orderBy($params->getOrderBy(), $params->getSortBy());
        }

        //check for specific fields requested
        if($this->fields_exists->checkFieldsExists($params->getFields()))
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

}
