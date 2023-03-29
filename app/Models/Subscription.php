<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = [
        'name',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at'
    ];
    protected $hidden = [
        'created_at',
        'updated at'
    ];          
}
