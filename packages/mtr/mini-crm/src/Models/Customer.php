<?php

namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtr\MiniCrm\Database\Factories\CustomerFactory;

class Customer extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'minicrm_customers';
    protected $table = self::TABLE_NAME;

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
}