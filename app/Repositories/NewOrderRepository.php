<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class NewOrderRepository
{
    public function getAll(): Builder
    {
        return Order::query();
    }
}
