<?php

namespace App\Strategies\OrderStrategies;

use App\Interfaces\FilterStrategy;

class CustomerMobileFilter implements FilterStrategy
{
    public function apply($request, $orders)
    {
        if ($request->has('mobile_number')) {
            $mobileNumber = $request->input('mobile_number');
            $orders = $orders->whereHas('customer', function ($query) use ($mobileNumber) {
                $query->where('mobile_number', $mobileNumber);
            });
        }
        return $orders;
    }
}
