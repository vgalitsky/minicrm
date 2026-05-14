<?php
namespace Mtr\MiniCrm\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    
    /**
     * The owner of the ticket
     * 
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * The ticket's manager
     * 
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    /**
     * Filter tickets by status
     * 
     * @param Builder $query
     * @param TicketStatus $status
     * 
     * @return Builder
     */
    public function scopeStatus(Builder $query, TicketStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Filter tickets created today.
     * 
     * @param Builder $query
     * 
     * @return Builder
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Filter tickets created this week.
     * 
     * @param Builder $query
     * 
     * @return Builder
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween(
            'created_at', 
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        );
    }

    /**
     * Filter tickets created this month.
     * 
     * @param Builder $query
     * 
     * @return Builder
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * @param Builder $query
     * @param string $date
     * 
     * @return Builder
     */
    public function scopeDateFrom(Builder $query, string $date): Builder
    {
        return $query->whereDate('created_at', '>=', $date);
    }

    /**
     * @param Builder $query
     * @param string $date
     * 
     * @return Builder
     */
    public function scopeDateTo(Builder $query, string $date): Builder
    {
        return $query->whereDate('created_at', '<=', $date);
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->status === TicketStatus::Closed;
    }
    
}