<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    /**
     * Get all of the orderDetails for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function customOrderDetails()
    {
        return $this->hasMany(CustomDish::class);
    }

    public function orderReceipts()
    {
        return $this->hasMany(OrderReceipt::class);
    }

    public function orderDishes()
    {
        $orders = $this->orderDetails->groupBy('dish_id');

        $dishes = Dish::all();

        $normalOrders = $orders->map(function ($item) use ($dishes) {
            $dish_id = $item->first()['dish_id'];
            return [
                'dish_name' => $dishes->where('id', $dish_id)->first()->name,
                'qty' => $item->sum('pcs')
            ];
        })->toArray();
        $customOrders = $this->customOrderDetails->map(function ($item) {
            return [
                'dish_name' => $item->name,
                'qty' => $item->pcs
            ];
        })->toArray();

        return array_merge($normalOrders, $customOrders);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function totalPrice()
    {
        $customPrices = $this->customOrderDetails->sum('price');
        $orderPrices = $this->orderDetails->sum('price');

        $total =  $customPrices + $orderPrices;

        if ($this->enable_discount == true) {
            if ($this->discount_type === 'percent') {
                $total = $total - ($total * $this->discount / 100);
            }

            if ($this->discount_type === 'fixed') {
                $total = $total - $this->discount;
            }
        }

        return $total;
    }

    public function totalPriceWithoutDiscount()
    {
        $customPrices = $this->customOrderDetails->sum('price');
        $orderPrices = $this->orderDetails->sum('price');

        return $orderPrices + $customPrices;
    }

    public function getDiscountOptionAttribute()
    {
        $discount = '';
        if ($this->enable_discount) {
            if ($this->discount_type == 'percent') {
                $discount = $this->discount . '%';
            }
            if ($this->discount_type == 'fixed') {
                $discount = '₱ ' . number_format($this->discount, 2, '.', ',');
            }

            $discount = '₱ ' . number_format($this->total, 2, '.', ',') . ' (' . $discount . ')';
        } else {
            $discount = '-';
        }
        return $discount;
    }


    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }

    public function table()
    {
        return $this->tables->first();
    }
}