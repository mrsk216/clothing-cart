<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $status;
    public $rejectionReason;

    public function __construct(Order $order, string $status, ?string $rejectionReason = null)
    {
        $this->order = $order;
        $this->status = $status;
        $this->rejectionReason = $rejectionReason;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        if ($this->status === 'approved') {
            return (new MailMessage)
                ->subject('Payment Verified - Order #' . $this->order->order_number)
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('Your payment for order #' . $this->order->order_number . ' has been verified and approved.')
                ->line('Order Total: ₹' . number_format($this->order->total, 2))
                ->line('Your order is now being processed.')
                ->action('View Order', url('/order/' . $this->order->id))
                ->line('Thank you for your business!');
        } else {
            return (new MailMessage)
                ->subject('Payment Verification Failed - Order #' . $this->order->order_number)
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('Unfortunately, your payment for order #' . $this->order->order_number . ' could not be verified.')
                ->line('Reason: ' . ($this->rejectionReason ?? 'No reason provided'))
                ->line('Order Total: ₹' . number_format($this->order->total, 2))
                ->line('Please submit a new payment proof or contact support.')
                ->action('View Order', url('/order/' . $this->order->id))
                ->line('We apologize for the inconvenience.');
        }
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->status,
            'rejection_reason' => $this->rejectionReason,
            'message' => $this->status === 'approved'
                ? 'Payment for order #' . $this->order->order_number . ' has been approved.'
                : 'Payment for order #' . $this->order->order_number . ' has been rejected. Reason: ' . ($this->rejectionReason ?? 'N/A'),
        ];
    }
}
