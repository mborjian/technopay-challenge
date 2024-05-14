<?php

namespace Tests\Unit;

use App\Exceptions\ApiException;
use App\Http\Controllers\Api\StrategyOrderController;
use App\Repositories\NewOrderRepository;
use App\Strategies\OrderFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class StrategyOrderControllerTest extends TestCase
{
    public function testFilter()
    {
        $orderFilterMock = $this->getMockBuilder(OrderFilter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $orderRepositoryMock = $this->getMockBuilder(NewOrderRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $controller = new StrategyOrderController($orderFilterMock, $orderRepositoryMock);

        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filteredOrdersMock = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $orderRepositoryMock->expects($this->once())
            ->method('getAll')
            ->willReturn($filteredOrdersMock);

        $orderFilterMock->expects($this->once())
            ->method('filter')
            ->with($requestMock, $filteredOrdersMock)
            ->willReturn($filteredOrdersMock);

        $response = $controller->filter($requestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }


    public function testFilterSuccessfulWithBuilder()
    {
        $orderFilter = Mockery::mock(OrderFilter::class);
        $orderRepository = Mockery::mock(NewOrderRepository::class);
        $request = Mockery::mock(Request::class);
        $builder = Mockery::mock(Builder::class);

        $collection = new Collection([['id' => 1, 'name' => 'Test Order']]);
        $orderRepository->shouldReceive('getAll')->once()->andReturn($builder);
        $orderFilter->shouldReceive('filter')->once()->with($request, $builder)->andReturn($builder);
        $builder->shouldReceive('get')->once()->andReturn($collection);

        $controller = new StrategyOrderController($orderFilter, $orderRepository);

        $response = $controller->filter($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode($collection), $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testFilterWithApiException()
    {
        $orderFilter = Mockery::mock(OrderFilter::class);
        $orderRepository = Mockery::mock(NewOrderRepository::class);
        $request = Mockery::mock(Request::class);

        $orderRepository->shouldReceive('getAll')->andThrow(new ApiException("Internal Server Error", 500));

        $controller = new StrategyOrderController($orderFilter, $orderRepository);

        $this->expectException(ApiException::class);
        $controller->filter($request);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
