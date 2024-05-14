<?php

namespace Tests\Feature;

use App\Exceptions\ApiException;
use App\Http\Controllers\Api\StrategyOrderController;
use App\Repositories\NewOrderRepository;
use App\Strategies\OrderFilter;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class StrategyOrderControllerTest extends TestCase
{
    public function testFilterWithApiException()
    {
        $orderFilter = Mockery::mock(OrderFilter::class);
        $orderRepository = Mockery::mock(NewOrderRepository::class);
        $request = Mockery::mock(Request::class);

        $exception = new ApiException("Some internal error", 500);

        $orderRepository->shouldReceive('getAll')->once()->andThrow($exception);

        $this->expectException(ApiException::class);

        $controller = new StrategyOrderController($orderFilter, $orderRepository);
        $controller->filter($request);
    }
}
