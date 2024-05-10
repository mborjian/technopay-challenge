<?php

namespace App\Specifications\OrderSpecifications;

use App\Specifications\Specification;

class CustomerNationalCodeSpecification implements Specification
{
    /**
     * The national code of order's customer for filtering orders.
     *
     * @var string
     */
    protected string $nationalCode;

    /**
     * CustomerNationalCodeSpecification constructor.
     *
     * @param string $nationalCode The national code of the customer for filtering orders.
     */
    public function __construct(string $nationalCode)
    {
        $this->nationalCode = $nationalCode;
    }

    /**
     * Apply the customer national code specification as a scope to the given query.
     *
     * @param $query
     * @return mixed
     */
    public function asScope($query): mixed
    {
        return $query->whereHas('customer', function ($query) {
            $query->where('national_code', $this->nationalCode);
        });
    }
}
