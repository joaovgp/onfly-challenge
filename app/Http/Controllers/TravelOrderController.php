<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\TravelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TravelOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin = Auth::user()->is_admin;

        if (!$isAdmin) {
            $orders = Auth::user()->travelOrders()
            ->latest()
            ->paginate(10)
            ->withQueryString();
        } else {
            $orders = TravelOrder::query()
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return Inertia::render('Dashboard', [
            'orders' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        Auth::user()->travelOrders()->create([
            ...$validated,
            'requester_name' => Auth::user()->name,
        ]);

        return redirect()->back()->with('message', 'Order created successfully!');
    }

    public function approve(TravelOrder $order)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $order->update(['status' => OrderStatus::APPROVED]);

        return redirect()->back()->with('message', 'Order approved successfully!');
    }

    public function cancel(TravelOrder $order)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $order->update(['status' => OrderStatus::CANCELED]);

        return redirect()->back()->with('message', 'Order canceled successfully!');
    }
}
