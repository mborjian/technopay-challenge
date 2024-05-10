<?php


namespace App\Specifications\OrderSpecifications;

use App\Specifications\Specification;

class CustomerMobileSpecification implements Specification
{
    /**
     * The mobile number of the customer for filtering orders.
     *
     * @var string
     */
    protected string $mobileNumber;

    /**
     * CustomerMobileSpecification constructor.
     *
     * @param string $mobileNumber The mobile number of the customer for filtering orders.
     */
    public function __construct(string $mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * Apply the customer mobile number specification as a scope to the given query.
     *
     * @param $query
     * @return mixed
     */
    public function asScope($query): mixed
    {
        return $query->whereHas('customer', function ($query) {
            $query->where('mobile_number', $this->mobileNumber);
        });
    }
}
