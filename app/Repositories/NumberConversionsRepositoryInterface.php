<?php

namespace App\Repositories;

use App\Repositories\ParamObj\NrConversionsRepoIndex;

interface NumberConversionsRepositoryInterface
{
    public function incrementForValue(int $value): void;

    /**
     * @param array $params - fields:array, sort_by:string, order_by:string
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(NrConversionsRepoIndex $params, bool $paginate = false);
}
