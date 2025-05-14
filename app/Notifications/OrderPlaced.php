<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPlaced extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // We’ll send via mail (you could add 'database', 'sms', etc.)
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Build the mail message
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Your Order Confirmation #' . $this->order->id)
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('Thank you for your order! Here are the details:');
    
        // List each item
        foreach ($this->order->orderItems as $item) {
            $price = $item->product->sale && $item->product->sale->isActive() 
                ? $item->product->discounted_price 
                : $item->product->price;

            $mail->line(
                "{$item->quantity} × {$item->product->name} — $" .
                number_format($price * $item->quantity, 2)
            );
        }
    
        // Calculate total based on order items directly
        $calculatedTotal = $this->order->orderItems->sum(function ($item) {
            return $item->quantity * ($item->product->sale && $item->product->sale->isActive() 
                ? $item->product->discounted_price 
                : $item->product->price);
        });
    
        // Shipping address
        $addr = $this->order->shippingAddress;
        $mail->line('')
             ->line('Shipping Address:')
             ->line($addr->line1)
             ->when($addr->line2, fn($m) => $m->line($addr->line2))
             ->line("{$addr->city}, {$addr->zip}")
             ->line($addr->country)
    
             // Correct Order total
             ->line('')
             ->line('**Order Total:** $' . number_format($calculatedTotal, 2))
    
             ->action('View Your Order', url("/dashboard/orders/{$this->order->id}"))
             ->line('We’ll let you know when it ships.');
    
        return $mail;
    }
    
}
