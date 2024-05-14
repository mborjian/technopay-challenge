<?php

namespace App\Strategies\OrderStrategies;

use App\Interfaces\FilterStrategy;

class OrderAmountRangeFilter implements FilterStrategy
{
    public function apply($request, $orders)
    {
        if ($request->has('min_amount') || $request->has('max_amount')) {
            $minAmount = $request->input('min_amount', 0);
            $maxAmount = $request->input('max_amount', PHP_INT_MAX);
            $orders = $orders->whereBetween('amount', [$minAmount, $maxAmount]);
        }
        return $orders;
    }
}
