<?php

namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Foundation\Auth\User as Authenticatable;
use Mtr\MiniCrm\Database\Factories\ManagerFactory;

class Manager extends Authenticatable
{
    use HasFactory;

    public const TABLE_NAME = 'minicrm_managers';
    protected $table = self::TABLE_NAME;

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
}