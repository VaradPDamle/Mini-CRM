<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Required for soft deletes

class Customer extends Model
{
    use HasFactory, SoftDeletes; // Use the HasFactory and SoftDeletes traits

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'profile_image',
    ];

    // You can add relationships here later (e.g., public function orders() { ... })
}