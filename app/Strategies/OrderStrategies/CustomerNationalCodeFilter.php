<?php

namespace App\Strategies\OrderStrategies;

use App\Interfaces\FilterStrategy;

class CustomerNationalCodeFilter implements FilterStrategy
{
    public function apply($request, $orders)
    {
        if ($request->has('national_code')) {
            $nationalCode = $request->input('national_code');
            $orders = $orders->whereHas('customer', function ($query) use ($nationalCode) {
                $query->where('national_code', $nationalCode);
            });
        }
        return $orders;
    }
}
