<?php
namespace Mtr\MiniCrm\Http\Resources\Api\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class StatisticsResource extends JsonResource
{
    /** 
     * {@inheritDoc}
    */
    public function toArray($request): array
    {
        return [
            'periods' => [
                'today' => $this->periodStat(Ticket::today()),
                'week' => $this->periodStat(Ticket::thisWeek()),
                'month' => $this->periodStat(Ticket::thisMonth()),
            ],
            "totals" => [
                'total' => Ticket::count(),
                'by_status' => $this->statisticsByStatus(Ticket::query()),
            ],
        ];
    }

    /**
     * Calculate statistics for a given period
     * 
     * @param Builder $query
     * @return array
     */
    private function periodStat(Builder $query): array
    {
        return [
            'total' => (clone $query)->count(),
            'by_status' => $this->statisticsByStatus($query),
        ];
    }

    /**
     * Calculate statistics grouped by ticket status
     * 
     * @param Builder $query
     * @return array
     */
    private function statisticsByStatus(Builder $query): array
    {
        $counts = (clone $query)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return collect(TicketStatus::cases())
            ->mapWithKeys(fn (TicketStatus $status) => [
                $status->label() => (int) ($counts[$status->value] ?? 'unknown status'),
            ])
            ->toArray();
    }
}