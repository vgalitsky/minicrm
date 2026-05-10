<?php
namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtr\MiniCrm\Database\Factories\TicketFactory;

class Ticket extends Model
{
    use HasFactory;

    const TABLE_NAME = 'minicrm_tickets';

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CLOSED = 'closed';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'customer_id',
        'manager_id',
        'subject',
        'description',
        'status',
        'answered_at',
        'response',
    ];

    /**
     * @return TicketFactory
     */
    protected static function newFactory()
    {
        return TicketFactory::new();
    }
}