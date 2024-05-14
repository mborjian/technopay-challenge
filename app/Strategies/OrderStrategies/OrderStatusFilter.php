<?php

namespace App\Strategies\OrderStrategies;

use App\Interfaces\FilterStrategy;
use Illuminate\Support\Facades\Log;

class OrderStatusFilter implements FilterStrategy
{
    public function apply($request, $orders)
    {
        if ($request->has('status')) {
            $status = $request->input('status');
            $orders = $orders->where('status', $status);
        }
        return $orders;
    }
}
