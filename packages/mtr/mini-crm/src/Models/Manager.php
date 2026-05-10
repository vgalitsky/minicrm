<?php

namespace Mtr\MiniCrm\Models;

use \Illuminate\Foundation\Auth\User as Authenticatable;
use Mtr\MiniCrm\Database\Factories\ManagerFactory;

class Manager extends Authenticatable
{
    protected $table = 'minicrm_managers';

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