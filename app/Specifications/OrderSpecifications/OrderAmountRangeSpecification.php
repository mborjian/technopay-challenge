<?php

namespace App\Specifications\OrderSpecifications;

use App\Specifications\Specification;

class OrderAmountRangeSpecification implements Specification
{
    /**
     * The minimum amount for filtering orders.
     *
     * @var float|null
     */
    protected mixed $minAmount;

    /**
     * The maximum amount for filtering orders.
     *
     * @var float|null
     */
    protected mixed $maxAmount;

    /**
     * OrderAmountRangeSpecification constructor.
     *
     * @param float|null $minAmount The minimum amount for filtering orders.
     * @param float|null $maxAmount The maximum amount for filtering orders.
     */
    public function __construct(float $minAmount = null, float $maxAmount = null)
    {
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
    }


    /**
     * Apply the order amount range specification as a scope to the given query.
     *
     * @param $query
     * @return mixed
     */
    public function asScope($query): mixed
    {
        if (!is_null($this->minAmount)) {
            $query = $query->where('amount', '>=', $this->minAmount);
        }
        if (!is_null($this->maxAmount)) {
            $query = $query->where('amount', '<=', $this->maxAmount);
        }
        return $query;
    }
}
