<?php

namespace Tests\Feature\TravelOrder;

use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTravelOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_authenticated_user_can_not_see_travel_order(): void
    {
        $order = TravelOrder::factory()->create();

        $response = $this->get('/travel-orders/' . $order->id);

        $this->assertInstanceOf(AuthenticationException::class, $response->exception);
    }

    public function test_authenticated_user_can_see_travel_order(): void
    {
        $user = User::factory()->create();
        $order = TravelOrder::factory()->for($user)->create();

        $this->actingAs($user)
            ->get('/travel-orders/' . $order->id)
            ->assertInertia(fn ($page) => $page
                ->component('Dashboard')
                ->has('order')
                ->where('order.id', $order->id)
            );
    }

    public function test_admin_user_can_see_travel_order(): void
    {
        $user = User::factory()->admin()->create();
        $order = TravelOrder::factory()->create();

        $this->actingAs($user)
            ->get('/travel-orders/' . $order->id)
            ->assertInertia(fn ($page) => $page
                ->component('Dashboard')
                ->has('order')
                ->where('order.id', $order->id)
            );
    }

    public function test_it_returns_error_if_order_not_found(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/travel-orders/999')
            ->assertStatus(302)
            ->assertSessionHasErrors('id');
    }
}
