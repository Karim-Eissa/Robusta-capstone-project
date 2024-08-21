<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function build()
    {
        return $this->from('noreply@yourdomain.com')
                    ->subject('Order Confirmation')
                    ->html("
                        <html>
                        <head><title>Order Confirmation</title></head>
                        <body>
                            <h1>Thank you for your order!</h1>
                            <p>Your order has been placed successfully.</p>
                            <p><strong>Order ID:</strong> {$this->order->id}</p>
                            <p><strong>Total:</strong> \${$this->order->total}</p>
                            <p><strong>Status:</strong> {$this->order->status}</p>
                            <p>We will notify you once your order is shipped.</p>
                        </body>
                        </html>
                    ");
    }
}
