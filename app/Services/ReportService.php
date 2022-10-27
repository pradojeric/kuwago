<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Category;

class ReportService {

    public function getOrders($date, $date2 = '', $dateType = 'single')
    {
        $orders = Category::with([
            'dishes' => function ($dish) {
                $dish->orderBy('name');
            },
            'dishes.orderDetails' => function ($order) use ($date, $date2, $dateType) {
                $order->when($dateType == 'single', function($query) use ($date){
                    $query->whereDate( 'created_at', $date );
                })
                ->when($dateType == 'range', function($query) use ($date, $date2) {
                    $query->whereRaw( 'DATE(created_at) BETWEEN ? AND ?', [$date, $date2] );
                });
            },
            'dishes.orderDetails.order' => function ($order) use ($date, $date2, $dateType) {
                $order->when($dateType == 'single', function($query) use ($date){
                    $query->whereDate( 'created_at', $date );
                })
                ->when($dateType == 'range', function($query) use ($date, $date2) {
                    $query->whereRaw( 'DATE(created_at) BETWEEN ? AND ?', [$date, $date2] );
                });
            },
        ])
        ->get();

        $orders = $orders->map(function ($order) {
            $item = [];
            foreach($order->dishes as $dish)
            {
                $item[] = [
                    'name' => $dish->name,
                    'properties' => $dish->properties,
                    'pcs' => $dish->orderDetails->sum('pcs'),
                    'price' => $dish->orderDetails->sum('price')
                ];
            }

            $sum = $order->dishes->sum(function ($dish) { return $dish->orderDetails->sum('price'); });

            return ['name' => $order->name, 'dishes' => $item, 'sum' => $sum];
        });

        $customs = Order::with([
            'customOrderDetails'
        ])
        ->has('customOrderDetails')
        ->when($dateType == 'single', function($query) use ($date){
            $query->whereDate( 'paid_on', $date );
        })
        ->when($dateType == 'range', function($query) use ($date, $date2) {
            $query->whereRaw( 'DATE(paid_on) BETWEEN ? AND ?', [$date, $date2] );
        })->get();

        $customs = $customs->flatMap(function ($order) {
            $item = [];

            foreach($order->customOrderDetails as $custom)
            {
                $item[] = [
                    'name' => $custom->name,
                    'properties' => $custom->description,
                    'pcs' => $custom->pcs,
                    'price' => $custom->price
                ];
            }
            return $item;
        });

        $customSum = $customs->sum('price');

        return $orders->merge(
            collect([
                [
                    'name' => 'Custom',
                    'dishes' => $customs,
                    'sum' => $customSum
                    ]
            ])
        )->toArray();
    }

}
