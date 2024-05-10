<?php

namespace App\Specifications;

interface Specification
{
    /**
     * Apply the specification as a scope to the given query.
     *
     * @param $query
     * @return mixed The modified query with the specification applied.
     */
    public function asScope($query): mixed;
}
