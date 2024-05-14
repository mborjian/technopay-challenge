<?php

namespace App\Interfaces;

interface FilterStrategy
{
    public function apply($request, $orders);
}
