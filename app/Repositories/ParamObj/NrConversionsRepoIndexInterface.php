<?php

namespace App\Repositories\ParamObj;

interface NrConversionsRepoIndexInterface
{
    /**
     * @return string|null
     */
    public function getOrderBy(): ?string;

    /**
     * @return string|null
     */
    public function getLimit(): ?string;

    /**
     * @return string|null
     */
    public function getSortBy(): ?string;

    /**
     * @return string|null
     */
    public function getFields(): ?array;
}
