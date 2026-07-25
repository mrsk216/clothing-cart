<?php

namespace App\Notifications;

use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentVerified extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $status,
        public ?string $rejectionReason = null
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        if ($this->status === 'approved') {
            $mail = (new MailMessage)
                ->subject('Payment Verified - Order #' . $this->order->order_number)
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('Your payment for order #' . $this->order->order_number . ' has been verified and approved.')
                ->line('Invoice Number: ' . ($this->order->invoice_number ?? 'N/A'))
                ->line('Order Total: Rs. ' . number_format((float) $this->order->total, 2))
                ->line('Your order is now being processed.')
                ->action('Download GST Invoice (PDF)', url('/download-invoice/' . $this->order->id))
                ->line('Thank you for your business!');

            if ($this->order->invoice_number) {
                try {
                    $pdf = app(InvoiceService::class)->output($this->order);
                    $mail->attachData(
                        $pdf,
                        'invoice-' . $this->order->invoice_number . '.pdf',
                        ['mime' => 'application/pdf']
                    );
                } catch (\Throwable $e) {
                    report($e);
                }
            }

            return $mail;
        }

        return (new MailMessage)
            ->subject('Payment Verification Failed - Order #' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Unfortunately, your payment for order #' . $this->order->order_number . ' could not be verified.')
            ->line('Reason: ' . ($this->rejectionReason ?? 'No reason provided'))
            ->line('Order Total: Rs. ' . number_format((float) $this->order->total, 2))
            ->line('You can submit a new payment proof from your order page.')
            ->action('Re-submit Payment Proof', url('/payment/submit/' . $this->order->id))
            ->line('We apologize for the inconvenience.');
    }
}
