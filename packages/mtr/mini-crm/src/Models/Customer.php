<?php

namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mtr\MiniCrm\Database\Factories\CustomerFactory;

class Customer extends MiniCrmModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
    
    /**
     * @return CustomerFactory
     */
    protected static function newFactory()
    {
        return CustomerFactory::new();
    }

    /**
     * Get the customer's tickets.
     * 
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'customer_id');
    }
}