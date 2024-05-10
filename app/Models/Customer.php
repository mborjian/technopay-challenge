<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Customer extends User
{
    use HasFactory;

    protected $table = 'users'; // Same as users model

    /**
     * To set the user type to 'customer' when creating customers
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($customer) {
            $customer->type = 'customer';
        });
    }
}
