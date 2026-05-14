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
        $query
            ->when($this->request->filled('status'), fn ($query) =>
                $query->status($this->request->enum('status', TicketStatus::class))
            )
            ->when($this->request->filled('date_from'), fn ($query) =>
                $query->dateFrom($this->request->date('date_from'))
            )
            ->when($this->request->filled('date_to'), fn ($query) =>
                $query->dateTo($this->request->date('date_to'))
            )
            ->when($this->request->filled('customer_email'), fn ($query) =>
                $query->whereHas('customer', fn ($customer) =>
                    $customer->where('email', 'like', '%' . $this->request->string('customer_email') . '%')
                )
            )
            ->when($this->request->filled('customer_phone'), fn ($query) =>
                $query->whereHas('customer', fn ($customer) =>
                    $customer->where('phone', 'like', '%' . preg_replace('/\D+/', '', $this->request->input('customer_phone')) . '%')
                )
            )
            ->when($this->request->filled('customer_name'), fn ($query) =>
                $query->whereHas('customer', fn ($customer) =>
                    $customer->where('name', 'like', '%' . $this->request->string('customer_name') . '%')
                )
            )
            ;
    }
}