<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Specifications\OrderSpecifications\CustomerMobileSpecification;
use App\Specifications\OrderSpecifications\CustomerNationalCodeSpecification;
use App\Specifications\OrderSpecifications\OrderAmountRangeSpecification;
use App\Specifications\OrderSpecifications\OrderStatusSpecification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Function of filtering orders based on incoming request parameters
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function filter(Request $request): JsonResponse
    {
        try {
            // For test ApiException
            // $a = 1 / 0;

            $specs = [];

            if ($request->has('status')) {
                $specs[] = new OrderStatusSpecification($request->status);
            }
            if ($request->has('national_code')) {
                $specs[] = new CustomerNationalCodeSpecification($request->national_code);
            }
            if ($request->has('mobile_number')) {
                $specs[] = new CustomerMobileSpecification($request->mobile_number);
            }
            if ($request->has('min_amount') || $request->has('max_amount')) {
                $specs[] = new OrderAmountRangeSpecification($request->min_amount, $request->max_amount);
            }

            $orders = $this->orderRepository->findBySpecs($specs);

            return response()->json($orders);

        } catch (Throwable $th) {
            Log::error($th->getMessage());
            throw new ApiException("Failed to fetch data from external service");
        }
    }
}
