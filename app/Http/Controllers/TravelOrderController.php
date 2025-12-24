<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\TravelOrder;
use App\Jobs\SendOrderStatusNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TravelOrderController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = Auth::user()->is_admin;
        $destination = $request->input('destination');
        $status = $request->input('status');
        $departureDate = $request->input('departure_date');
        $returnDate = $request->input('return_date');

        $query = $isAdmin ? TravelOrder::query() : Auth::user()->travelOrders();

        if ($destination) {
            $query->where('destination', 'like', "%{$destination}%");
        }

        if ($status && count($status)) {
            $query->whereIn('status', $status);
        }

        if ($departureDate) {
            $query->whereDate('departure_date', '>=', $departureDate);
        }

        if ($returnDate) {
            $query->whereDate('return_date', '<=', $returnDate);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Dashboard', [
            'orders' => $orders,
            'order' => null,
        ]);
    }

    public function show($id)
    {
        try {
            $order = TravelOrder::query()->findOrFail($id);

            return Inertia::render('Dashboard', [
                'orders' => null,
                'order' => $order
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['id' => 'Travel order not found.']);
        }
    }

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
        if ($order->status !== OrderStatus::REQUESTED) {
            abort(400);
        }

        $order->update(['status' => OrderStatus::APPROVED]);

        SendOrderStatusNotification::dispatch($order);

        return redirect()->back()->with('message', 'Order approved successfully!');
    }

    public function cancel(TravelOrder $order)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        if ($order->status !== OrderStatus::REQUESTED) {
            abort(400);
        }

        $order->update(['status' => OrderStatus::CANCELED]);

        SendOrderStatusNotification::dispatch($order);

        return redirect()->back()->with('message', 'Order canceled successfully!');
    }
}
