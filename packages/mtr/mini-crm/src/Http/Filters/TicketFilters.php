<?php
namespace Mtr\MiniCrm\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Mtr\MiniCrm\Http\Requests\TicketFiltersRequest;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class TicketFilters
{
    /**
     * @param TicketFiltersRequest $request
     */
    public function __construct(private readonly TicketFiltersRequest $request)
    {
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function __invoke(Builder $query): void
    {
        $filters = $this->request->validated();

        $query
            ->when(!empty($filters['status']), fn ($query) =>
                $query->status(TicketStatus::from($filters['status']))
            )
            ->when(!empty($filters['date_from']), fn ($query) =>
                $query->dateFrom($filters['date_from'])
            )
            ->when(!empty($filters['date_to']), fn ($query) =>
                $query->dateTo($filters['date_to'])
            )
            ->when(!empty($filters['customer_email']), fn ($query) =>
                $query->whereHas('customer', fn ($customer) =>
                    $customer->where('email', 'like', '%' . $this->escapeLike($filters['customer_email']) . '%')
                )
            )
            ->when(!empty($filters['customer_phone']), fn ($query) =>
                $query->whereHas('customer', fn ($customer) =>
                    $customer->where('phone', 'like', '%' . preg_replace('/\D+/', '', $filters['customer_phone']) . '%')
                )
            )
            ->when(!empty($filters['customer_name']), fn ($query) =>
                $query->whereHas('customer', fn ($customer) =>
                    $customer->where('name', 'ilike', '%' . $this->escapeLike($filters['customer_name']) . '%')
                )
            )
            ;
    }

    /**
     * @param string $value
     * @return string
     */
    private function escapeLike(string $value): string
    {
        return addcslashes(trim($value), '\\%_');
    }
}