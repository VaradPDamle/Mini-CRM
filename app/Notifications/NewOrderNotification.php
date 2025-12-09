<?php

namespace App\Notifications;

use App\Models\Order; // Import the Order Model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order; // Public property to hold the order

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Define the URL to view the order in the CRM
        $orderUrl = route('orders.edit', $this->order);
        
        return (new MailMessage)
                    ->subject('🚨 New Order Created: #' . $this->order->order_number)
                    ->line('A new order has been placed in the CRM by ' . auth()->user()->name . '.')
                    ->line('**Order Details:**')
                    ->line('Order Number: **' . $this->order->order_number . '**')
                    ->line('Customer: **' . $this->order->customer->name . '**')
                    ->line('Amount: **₹' . number_format($this->order->amount, 2) . '**')
                    ->action('Review Order', $orderUrl)
                    ->line('Thank you for using the ImpactGuru CRM.');
    }
}