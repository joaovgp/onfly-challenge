<?php

namespace Tests\Feature\TravelOrder;

use App\Models\User;
use App\Models\TravelOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\OrderStatus;

class AdminActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_user_cannot_approve_a_travel_order(): void
    {
        $user = User::factory()->create();
        $order = TravelOrder::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(route('travel-orders.approve', $order));

        $response->assertStatus(403);
    }

    public function test_regular_user_cannot_cancel_a_travel_order(): void
    {
        $user = User::factory()->create();
        $order = TravelOrder::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(route('travel-orders.cancel', $order));

        $response->assertStatus(403);
    }

    public function test_admin_can_approve_a_travel_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = TravelOrder::factory()->create([
            'status' => OrderStatus::REQUESTED
        ]);

        $response = $this->actingAs($admin)->post(route('travel-orders.approve', $order));

        $this->assertDatabaseHas('travel_orders', [
            'id' => $order->id,
            'status' => OrderStatus::APPROVED,
        ]);
    }

    public function test_cannot_approve_a_cancelled_travel_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = TravelOrder::factory()->create([
            'status' => OrderStatus::CANCELED
        ]);

        $response = $this->actingAs($admin)->post(route('travel-orders.approve', $order));

        $response->assertStatus(400);
    }

    public function test_admin_can_cancel_a_travel_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = TravelOrder::factory()->create([
            'status' => OrderStatus::REQUESTED
        ]);

        $response = $this->actingAs($admin)->post(route('travel-orders.cancel', $order));

        $this->assertDatabaseHas('travel_orders', [
            'id' => $order->id,
            'status' => OrderStatus::CANCELED,
        ]);
    }

    public function test_cannot_cancel_an_approved_travel_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = TravelOrder::factory()->create([
            'status' => OrderStatus::APPROVED
        ]);

        $response = $this->actingAs($admin)->post(route('travel-orders.cancel', $order));

        $response->assertStatus(400);
    }
}
