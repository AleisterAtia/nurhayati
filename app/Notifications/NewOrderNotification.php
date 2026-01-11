<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan ke database
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'user_name' => $this->order->user->name,
            'message' => 'Pesanan baru #' . $this->order->order_number . ' masuk!',
            'link' => route('orders.edit', $this->order->id), // Link ke detail pesanan
        ];
    }
}