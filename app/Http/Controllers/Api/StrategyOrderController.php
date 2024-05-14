<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Repositories\NewOrderRepository;
use App\Strategies\OrderFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class StrategyOrderController extends Controller
{
    private OrderFilter $orderFilter;
    private NewOrderRepository $orderRepository;

    public function __construct(OrderFilter $orderFilter, NewOrderRepository $orderRepository)
    {
        $this->orderFilter = $orderFilter;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @throws ApiException
     */
    public function filter(Request $request): JsonResponse
    {
        try {
            $orders = $this->orderRepository->getAll();
            $filteredOrders = $this->orderFilter->filter($request, $orders);

            if ($filteredOrders instanceof Builder) {
                $filteredOrders = $filteredOrders->get();
            }

            return response()->json($filteredOrders);
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), 500);
        }
    }
}
