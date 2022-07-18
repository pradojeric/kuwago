<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class ServiceType extends Component
{
    public $message = '';

    protected $listeners = [
        'echo:newOrder,AnyOrderUpdatedEvent' => '$refresh',
    ];

    public function refreshComponent()
    {
        session()->flash('message', 'Page updated. Please refresh the page!');
    }

    public function render()
    {
        $orders = Order::with(['orderDetails'])->where('checked_out', 0)->whereDate('created_at', now())->get();
        $unpaidOrders = Order::with(['orderDetails'])->where('checked_out', 0)->whereDate('created_at', '<>' ,now())->get();


        return view('livewire.order.service-type', [
            'orders' => $orders,
            'unpaidOrders' => $unpaidOrders,
        ]);
    }
}
