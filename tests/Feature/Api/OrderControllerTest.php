<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = User::factory()->create([
            'mobile_number' => '0911111111',
            'national_code' => '1234567890'
        ]);

        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    /**
     * Test orders can be filtered by customer's mobile number.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByMobileNumber()
    {
        $order1 = Order::factory()->create(['customer_id' => $this->customer->id]);
        $order2 = Order::factory()->create(['customer_id' => $this->customer->id]);

        $response = $this->actingAs($this->customer)->json('GET', '/api/backoffice/orders', ['mobile_number' => '0911111111']);

        $response->assertStatus(200);

        $response->assertJsonCount(2);
    }


    /**
     * Test orders can be filtered by customer's national code.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByNationalCode()
    {
        $order1 = Order::factory()->create(['customer_id' => $this->customer->id]);
        $order2 = Order::factory()->create(['customer_id' => $this->customer->id]);

        $response = $this->actingAs($this->user)->json('GET', '/api/backoffice/orders', ['national_code' => '1234567890']);

        $response->assertStatus(200);

        $response->assertJsonCount(2);
    }


    /**
     * Test orders can be filtered by status.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByStatus()
    {
        $order1 = Order::factory()->create([
            'status' => 'pending',
            'customer_id' => $this->customer->id,
            'amount' => 100.00,
        ]);

        $order2 = Order::factory()->create([
            'status' => 'completed',
            'customer_id' => $this->customer->id,
            'amount' => 150.00,
        ]);

        $response = $this->actingAs($this->customer)->json('GET', '/api/backoffice/orders', ['status' => 'pending']);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'status' => 'pending',
            'amount' => 100.00,
        ]);

        $response->assertJsonMissing([
            'status' => 'completed'
        ]);
    }


    /**
     * Test orders can be filtered by minimum amount.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByMinimumAmount()
    {
        Order::factory()->create(['amount' => 200, 'customer_id' => $this->customer->id]);
        Order::factory()->create(['amount' => 300, 'customer_id' => $this->customer->id]);

        $response = $this->actingAs($this->user)->json('GET', '/api/backoffice/orders', ['min_amount' => 250]);

        $response->assertStatus(200);

        $response->assertJsonCount(1);
    }


    /**
     * Test orders can be filtered by maximum amount.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByMaximumAmount()
    {
        Order::factory()->create(['amount' => 150, 'customer_id' => $this->customer->id]);
        Order::factory()->create(['amount' => 100, 'customer_id' => $this->customer->id]);

        $response = $this->actingAs($this->user)->json('GET', '/api/backoffice/orders', ['max_amount' => 120]);

        $response->assertStatus(200);

        $response->assertJsonCount(1);
    }

    /**
     * Test orders can be filtered by mix of minimum and maximum amount.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByMixOfMinAndMaxAmount()
    {
        Order::factory()->create(['amount' => 100, 'customer_id' => $this->customer->id]);
        Order::factory()->create(['amount' => 200, 'customer_id' => $this->customer->id]);
        Order::factory()->create(['amount' => 300, 'customer_id' => $this->customer->id]);

        $response = $this->actingAs($this->user)->json('GET', '/api/backoffice/orders', ['min_amount' => 150, 'max_amount' => 250]);

        $response->assertStatus(200);

        $response->assertJsonCount(1);
    }


    /**
     * Test orders can be filtered by mix of all criteria.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByMultipleCriteria()
    {
        $order1 = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'pending',
            'amount' => 500.00,
        ]);

        $order2 = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'completed',
            'amount' => 150.00,
        ]);

        $order3 = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'pending',
            'amount' => 750.00,
        ]);

        $order4 = Order::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'completed',
            'amount' => 2000.00,
        ]);

        $response = $this->actingAs($this->user)->json('GET', '/api/backoffice/orders', [
            'status' => 'completed',
            'mobile_number' => '0911111111',
            'national_code' => '1234567890',
            'min_amount' => 100,
            'max_amount' => 1000
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(1);

        $response->assertJsonFragment([
            'status' => 'completed',
            'amount' => 150.00,
            'customer_id' => $this->customer->id
        ]);
    }
}
