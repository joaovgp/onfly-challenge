<?php

namespace Tests\Feature\TravelOrder;

use App\Models\User;
use App\Models\TravelOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTravelOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_all_travel_orders(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        TravelOrder::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 5)
        );
    }

    public function test_user_can_only_see_their_own_travel_orders(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        TravelOrder::factory()->count(3)->for($user)->create();
        TravelOrder::factory()->count(2)->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 3)
        );
    }

    public function test_it_filters_by_destination(): void
    {
        $user = User::factory()->create();
        TravelOrder::factory()->for($user)->create(['destination' => 'Paris']);
        TravelOrder::factory()->for($user)->create(['destination' => 'London']);

        $response = $this->actingAs($user)->get(route('dashboard', ['destination' => 'Paris']));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 1)
            ->where('orders.data.0.destination', 'Paris')
        );
    }

    public function test_it_filters_by_status(): void
    {
        $user = User::factory()->create();
        TravelOrder::factory()->for($user)->create(['status' => 'APPROVED']);
        TravelOrder::factory()->for($user)->create(['status' => 'REQUESTED']);

        $response = $this->actingAs($user)->get(route('dashboard', ['status' => ['APPROVED']]));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 1)
            ->where('orders.data.0.status', 'APPROVED')
        );
    }

    public function test_it_filters_by_departure_date(): void
    {
        $user = User::factory()->create();
        TravelOrder::factory()->for($user)->create(['departure_date' => '2025-01-10']);
        TravelOrder::factory()->for($user)->create(['departure_date' => '2025-01-15']);

        $response = $this->actingAs($user)->get(route('dashboard', ['departure_date' => '2025-01-12']));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 1)
            ->where('orders.data.0.departure_date', 'Jan 15, 2025')
        );
    }

    public function test_it_filters_by_return_date(): void
    {
        $user = User::factory()->create();
        TravelOrder::factory()->for($user)->create(['return_date' => '2025-01-20']);
        TravelOrder::factory()->for($user)->create(['return_date' => '2025-01-25']);

        $response = $this->actingAs($user)->get(route('dashboard', ['return_date' => '2025-01-22']));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 1)
            ->where('orders.data.0.return_date', 'Jan 20, 2025')
        );
    }

    public function test_it_filters_by_departure_and_return_date(): void
    {
        $user = User::factory()->create();
        TravelOrder::factory()->for($user)->create([
            'departure_date' => '2025-01-10',
            'return_date' => '2025-01-15'
        ]);
        TravelOrder::factory()->for($user)->create([
            'departure_date' => '2025-01-12',
            'return_date' => '2025-01-18'
        ]);
        TravelOrder::factory()->for($user)->create([
            'departure_date' => '2025-01-20',
            'return_date' => '2025-01-25'
        ]);


        $response = $this->actingAs($user)->get(route('dashboard', [
            'departure_date' => '2025-01-11',
            'return_date' => '2025-01-19'
        ]));

        $response->assertInertia(fn ($assert) => $assert
            ->component('Dashboard')
            ->has('orders.data', 1)
            ->where('orders.data.0.departure_date', 'Jan 12, 2025')
        );
    }
}
