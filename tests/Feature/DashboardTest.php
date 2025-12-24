<?php

namespace Tests\Feature;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_shows_travel_orders_list_by_default()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard')
                ->has('orders')
                ->where('order', null)
            );
    }
}
