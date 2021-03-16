<?php


namespace App\Repositories\ParamObj;


class NrConversionsRepoIndex implements NrConversionsRepoIndexInterface
{

    private ?string $order_by = null;
    private ?int $limit = null;
    private ?string $sort_by = 'asc';
    private ?array $fields = null;

    /**
     * NrConversionsRepoIndex constructor.
     * @param string|null $order_by
     * @param string|null $limit
     * @param string|null $sort_by
     * @param string|null $fields
     */
    public function __construct(?string $fields, ?string $order_by, ?string $sort_by, ?int $limit)
    {
        $this->order_by = $order_by;
        $this->limit = $limit;
        $this->sort_by = strtolower($sort_by) === 'desc' ? 'desc' : $this->sort_by;
        $this->fields = explode(',', $fields);
    }

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->order_by;
    }

    /**
     * @return string|null
     */
    public function getLimit(): ?string
    {
        return $this->limit;
    }

    /**
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sort_by;
    }

    /**
     * @return string|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}
