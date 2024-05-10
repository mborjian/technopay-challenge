<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Specifications\OrderSpecifications\CustomerMobileSpecification;
use App\Specifications\OrderSpecifications\CustomerNationalCodeSpecification;
use App\Specifications\OrderSpecifications\OrderAmountRangeSpecification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test filtering orders by customer national code.
     *
     * @return void
     */
    public function testCanFilterOrdersByCustomerNationalCode()
    {
        $user = User::factory()->create([
            'national_code' => '1234567890'
        ]);

        $order = Order::factory()->create(['customer_id' => $user->id]);
        $order2 = Order::factory()->create();  // False

        $specification = new CustomerNationalCodeSpecification('1234567890');
        $orderRepository = new OrderRepository();

        $results = $orderRepository->findBySpecs([$specification]);

        $this->assertTrue($results->contains($order));
        $this->assertFalse($results->contains($order2));
    }

    /**
     * Test filtering orders by customer mobile number.
     *
     * @return void
     */
    public function testCanFilterOrdersByCustomerMobile()
    {
        $user = User::factory()->create([
            'mobile_number' => '0910000000'
        ]);

        $order = Order::factory()->create(['customer_id' => $user->id]);
        $order2 = Order::factory()->create();  // False

        $specification = new CustomerMobileSpecification('0910000000');
        $orderRepository = new OrderRepository();

        $results = $orderRepository->findBySpecs([$specification]);

        $this->assertTrue($results->contains($order));
        $this->assertFalse($results->contains($order2));
    }

    /**
     * Test filtering orders by amount range.
     *
     * @return void
     */
    public function testCanFilterOrdersByAmountRange()
    {
        $order = Order::factory()->create(['amount' => 500.00]);
        $order2 = Order::factory()->create(['amount' => 1500.00]);  // False

        $specification = new OrderAmountRangeSpecification(100, 1000);
        $orderRepository = new OrderRepository();

        $results = $orderRepository->findBySpecs([$specification]);

        $this->assertTrue($results->contains($order));
        $this->assertFalse($results->contains($order2));
    }
}
