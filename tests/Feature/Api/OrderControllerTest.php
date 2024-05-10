<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    /**
     * Test orders can be filtered by status.
     *
     * @return void
     */
    public function testOrdersCanBeFilteredByStatus()
    {
        $user = User::factory()->create();

        $order1 = Order::factory()->create([
            'status' => 'pending',
            'customer_id' => $user->id,
            'amount' => 100.00,
        ]);

        $order2 = Order::factory()->create([
            'status' => 'completed',
            'customer_id' => $user->id,
            'amount' => 150.00,
        ]);

        $response = $this->actingAs($user)->json('GET', '/api/backoffice/orders', ['status' => 'pending']);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'status' => 'pending',
            'amount' => 100.00,
        ]);

        $response->assertJsonMissing([
            'status' => 'completed'
        ]);
    }
}
