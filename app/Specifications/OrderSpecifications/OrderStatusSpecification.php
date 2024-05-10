<?php

namespace App\Specifications\OrderSpecifications;

use App\Specifications\Specification;

class OrderStatusSpecification implements Specification
{
    /**
     * The status to filter orders.
     *
     * @var string
     */
    protected string $status;

    /**
     * OrderStatusSpecification constructor.
     *
     * @param string $status The status to filter orders.
     */
    public function __construct(mixed $status)
    {
        $this->status = $status;
    }


    /**
     * Apply the order status specification as a scope to the given query.
     *
     * @param $query
     * @return mixed The modified query with the order status specification applied.
     */
    public function asScope($query): mixed
    {
        return $query->where('status', $this->status);
    }
}
