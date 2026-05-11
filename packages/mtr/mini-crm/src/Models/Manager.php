<?php

namespace Mtr\MiniCrm\Models;

use \Illuminate\Foundation\Auth\User as Authenticatable;
use Mtr\MiniCrm\Database\Factories\ManagerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Mtr\MiniCrm\Models\Attributes\HasTablePrefix;

class Manager extends Authenticatable
{
    use HasFactory;
    use HasTablePrefix;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * @return ManagerFactory
     */
    protected static function newFactory()
    {
        return ManagerFactory::new();
    }

    /**
     * Get the tickets assigned to the manager.
      * 
      * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'manager_id');
    }

    /**
     * Get the customers associated with the manager through tickets.
     * 
     * @return HasManyThrough
     */
    public function customers(): HasManyThrough
    {
        return $this->hasManyThrough(Customer::class, Ticket::class, 'manager_id', 'id', 'id', 'customer_id');
    }

}