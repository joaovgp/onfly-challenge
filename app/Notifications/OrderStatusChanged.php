<?php

namespace App\Notifications;

use App\Models\TravelOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public TravelOrder $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = strtolower($this->order->status->name);
        $requesterName = $this->order->requester_name;
        $destination = $this->order->destination;
        $departureDate = $this->order->departure_date->format('d/m/Y');
        $returnDate = $this->order->return_date->format('d/m/Y');

        return (new MailMessage)
            ->subject("Your travel order has been {$status}")
            ->greeting("Hello, {$requesterName}!")
            ->line("Your travel order to {$destination} from {$departureDate} to {$returnDate} has been {$status}.");
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
