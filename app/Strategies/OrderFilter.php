<?php

namespace App\Strategies;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderFilter
{
    private array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function filter(Request $request, $orders)
    {
        foreach ($this->strategies as $strategy) {
            $orders = $strategy->apply($request, $orders);
        }
        return $orders;
    }
}
