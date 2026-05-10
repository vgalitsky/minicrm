<?php

namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Model;
use Mtr\MiniCrm\Database\Factories\CustomerFactory;

class Customer extends Model
{
    protected $table = 'minicrm_customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    protected static function newFactory()
    {
        return CustomerFactory::new();
    }
}