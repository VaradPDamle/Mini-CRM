<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Order extends Model
{
    use HasFactory, SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'order_number',
        'amount',
        'status',
        'order_date',
    ];

    /**
     * Get the customer that owns the order (One-to-Many inverse relationship).
     */
    public function customer()
    {
        // Assumes the foreign key is 'customer_id'
        return $this->belongsTo(Customer::class);
    }
}