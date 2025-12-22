<?php

namespace Tests\Feature\TravelOrder;

use App\Enums\OrderStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTravelOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_authenticated_user_can_not_create_travel_order(): void
    {
        $response = $this->post('/travel-orders', [
            'destination' => 'New York',
            'departure_date' => Carbon::now()->toDateString('Y-m-d'),
            'return_date' => Carbon::now()->addDays(5)->toDateString('Y-m-d')
        ]);

        $this->assertInstanceOf(AuthenticationException::class, $response->exception);
    }

    public function test_authenticated_user_can_create_travel_order(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $destination = 'New York';
        $departure = Carbon::now()->toDateString('Y-m-d');
        $return = Carbon::now()->addDays(5)->toDateString('Y-m-d');

        $this->post('/travel-orders', [
            'destination' => $destination,
            'departure_date' => $departure,
            'return_date' => $return
        ]);

        $this->assertDatabaseHas('travel_orders', [
            'user_id' => $user->id,
            'requester_name' => $user->name,
            'destination' => $destination,
            'departure_date' => $departure,
            'return_date' => $return,
            'status' => OrderStatus::REQUESTED
        ]);
    }

    public function test_admin_user_can_create_travel_order(): void
    {
        $user = User::factory()->admin()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $destination = 'New York';
        $departure = Carbon::now()->toDateString('Y-m-d');
        $return = Carbon::now()->addDays(5)->toDateString('Y-m-d');

        $this->post('/travel-orders', [
            'destination' => $destination,
            'departure_date' => $departure,
            'return_date' => $return
        ]);

        $this->assertDatabaseHas('travel_orders', [
            'user_id' => $user->id,
            'requester_name' => $user->name,
            'destination' => $destination,
            'departure_date' => $departure,
            'return_date' => $return,
            'status' => OrderStatus::REQUESTED
        ]);
    }
}
