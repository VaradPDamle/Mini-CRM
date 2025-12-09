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
     * The attributes that should be cast to native types.
     *
     * Casting `order_date` to `date` will return a Carbon instance
     * so templates can safely call ->format() on it.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_date' => 'date',
        'amount' => 'decimal:2',
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