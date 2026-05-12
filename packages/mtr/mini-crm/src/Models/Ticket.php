<?php
namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mtr\MiniCrm\Database\Factories\TicketFactory;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class Ticket extends MiniCrmModel
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'manager_id',
        'subject',
        'description',
        'status',
        'answered_at',
        'response',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'answered_at' => 'datetime',
    ];

    /**
     * @return TicketFactory
     */
    protected static function newFactory()
    {
        return TicketFactory::new();
    }
}