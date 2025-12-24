<?php

namespace App\Jobs;

use App\Models\TravelOrder;
use App\Notifications\OrderStatusChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderStatusNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public TravelOrder $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->order->user->notify(new OrderStatusChanged($this->order));
    }
}
