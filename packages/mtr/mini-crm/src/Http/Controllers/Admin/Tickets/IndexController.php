<?php
namespace Mtr\MiniCrm\Http\Controllers\Admin\Tickets;

use Illuminate\Routing\Controller;
use Mtr\MiniCrm\Http\Filters\TicketFilters;
use Mtr\MiniCrm\Http\Requests\TicketFiltersRequest;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class IndexController extends Controller
{
    /**
     * Ticket listing
     * 
     * @param TicketFiltersRequest $request
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index(TicketFiltersRequest $request)
    {
        $tickets = Ticket::with(['customer', 'manager'])
            ->tap(new TicketFilters($request))
            ->latest()
            ->paginate(15);
        ;

        return view('minicrm::admin.tickets.index', [
            'filters' => $request->validated() ?? [],
            'tickets' => $tickets,
            'statuses' => TicketStatus::values(),
        ]);
    }
}