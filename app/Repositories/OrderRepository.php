<?php

namespace App\Repositories;


use App\Models\Order;
use App\Specifications\Specification;
use Illuminate\Database\Eloquent\Collection;


class OrderRepository
{
    /**
     * Find orders matching the given single specification.
     *
     * @param Specification $specification The specification to filter orders.
     * @return Collection Returns a collection of orders that match the specification.
     */
    public function findBySpec(Specification $specification): Collection
    {
        return Order::where($specification->asScope(Order::query()))->get();
    }


    /**
     * Find orders matching the given array of specifications.
     *
     * @param array $specs An array of specifications to filter orders.
     * @return Collection Returns a collection of orders that match the combined specifications.
     */
    public function findBySpecs(array $specs): Collection
    {
        $query = Order::query();

        foreach ($specs as $spec) {
            $query = $spec->asScope($query);
        }

        return $query->get();
    }
}
